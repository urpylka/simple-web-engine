#! /usr/bin/env python3

# source venv/bin/activate

from flask import Flask, jsonify, request, Response
from flask_sqlalchemy import SQLAlchemy
from sqlalchemy.ext.declarative import declared_attr
from sqlalchemy.dialects.postgresql import UUID
from sqlalchemy.inspection import inspect
from flask_sqlalchemy.model import DefaultMeta
from werkzeug.security import generate_password_hash, check_password_hash
# from sqlalchemy.orm import relationship
from sqlalchemy.sql import func
import uuid

# https://stackoverflow.com/questions/183042/how-can-i-use-uuids-in-sqlalchemy
import psycopg2, datetime
from functools import wraps
# from db_models import Serializer, Perm, Tag, Session, User, Post

app = Flask(__name__)
# https://pythonru.com/uroki/14-sozdanie-baz-dannyh-vo-flask
app.config['SQLALCHEMY_DATABASE_URI'] = 'postgresql://postgres:example@localhost:5432/postgres'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False
db = SQLAlchemy(app)

def go_recursive(o):
    """
    Reursive handler for list & dicr
    """
    if isinstance(o, list):
        # we can't change o[i] (error: _sa_instance_state)
        L = []
        for i in range(len(o)):
            if type(o[i]).__name__ == "AppenderBaseQuery":
                L.append(all())
            elif issubclass(type(o[i]), db.Model):
                L.append(o[i].id)
            # run out infinity recursion
            elif isinstance(o[i], (list, dict)):
                L.append(go_recursive(o[i]))
            else:
                L.append(o[i])
        o = L

    if isinstance(o, dict):
        for i in o:
            if type(o[i]).__name__ == "AppenderBaseQuery":
                o[i] = o[i].all()
            if issubclass(type(o[i]), db.Model):
                o[i] = o[i].id
            if isinstance(o[i], (list, dict)):
                o[i] = go_recursive(o[i])
    return o

class Serializer(object):
    '''
    Source:
    https://stackoverflow.com/questions/7102754/jsonify-a-sqlalchemy-result-set-in-flask

    Use:
    def get_user(id):
        user = UserModel.query.get(id)
        return json.dumps(user.serialize())

    def get_users():
        users = UserModel.query.all()
        return json.dumps(UserModel.serialize_list(users))
    '''

    def serialize(self):
        s = {c: getattr(self, c) for c in inspect(self).attrs.keys()}
        # print(s)

        s = go_recursive(s)
        return s

    @staticmethod
    def serialize_list(l):
        return [m.serialize() for m in l]

swe_perms_users = db.Table('swe_perms_users',
    db.Column('perm_id', db.Integer, db.ForeignKey('swe_perm.id')),
    db.Column('user_id', db.Integer, db.ForeignKey('swe_user.id'))
)

class Perm(db.Model, Serializer):
    __tablename__ = "swe_perm"
    id = db.Column(db.Integer(), primary_key=True)
    name = db.Column(db.String(64), unique=True, nullable=False)
    description = db.Column(db.String(255))
    update_on = db.Column(db.DateTime, nullable=False, server_default=func.now(), onupdate=datetime.datetime.utcnow)

    def get(perm_name):
        try:
            perm = Perm.query.filter_by(name=perm_name).one()
            return perm
        except Exception as ex:
            if str(ex).startswith("No row was found for one()"):
                return Perm(name=perm_name)
            raise Exception(str(ex))

class User(db.Model, Serializer):
    __tablename__ = "swe_user"

    id = db.Column(db.Integer, primary_key=True, autoincrement=True)
    # id = db.Column(db.Integer, db.Sequence('user_id_seq', start=1, increment=1), primary_key=True, autoincrement=True)
    email = db.Column(db.String(128), unique=True, nullable=False)
    # Username is important since shouldn't expose email to other users in most cases.
    fullname = db.Column(db.String(64), nullable=False)
    password_hash = db.Column(db.String(100), unique=True, nullable=False)
    activated = db.Column(db.Boolean(), nullable=False, default=False)
    created_at = db.Column(db.DateTime, nullable=False, server_default=func.now())
    update_on = db.Column(db.DateTime, nullable=False, server_default=func.now(), onupdate=datetime.datetime.utcnow)

    @declared_attr
    def perms(cls):
        # The first arg is a class name, the backref is a column name
        return db.relationship(
            "Perm",
            secondary=swe_perms_users,
            backref=db.backref("users", lazy="dynamic"),
        )

    perms = db.relationship('Perm', secondary=swe_perms_users, backref=db.backref('users', lazy='dynamic'))

    # один ко многим
    sessions = db.relationship('Session', backref='swe_user', lazy='dynamic')

    def __init__(self, fullname, email, perms, password):
        self.fullname = fullname
        self.email = email
        # self.password_hash = password
        self.set_password(password)
        # self.activated = False
        # it need to check with an email
        self.activate()

        for perm in perms.split(','):
            self.perms.append(Perm.get(perm))

    def set_password(self, password):
        self.password_hash = generate_password_hash(password)

    def check_password(self,  password):
        # https://pythonru.com/uroki/18-autentifikacija-vo-flask
        # https://flask-httpauth.readthedocs.io/en/latest/
        return check_password_hash(self.password_hash, password)

    def serialize(self):
        d = Serializer.serialize(self)

        # try:
        #     x = []
        #     for i in range(len(d['perms'])):
        #         x.append(d['perms'][i].id)
        #     d['perms'] = x

        #     # x = d['perms'][0].id
        #     # y = d['perms'][1].id
        #     # d['perms'] = [x, y]

        #     # # Error: 'int' object has no attribute '_sa_instance_state'
        #     # d['perms'][0] = d['perms'][0].id
        #     # d['perms'][1] = d['perms'][1].id

        # except Exception as ex:
        #     print("Error: " + str(ex))

        # if type(d['sessions']).__name__ == "AppenderBaseQuery":
        #     d['sessions'] = d['sessions'].all()

        del d['password_hash']
        return d

    def activate(self):
        self.activated = True

    def is_activated(self):
        return self.activated

    def is_admin(self):
        for role in self.perms:
            return role.name == "admin"

class Session(db.Model):
    __tablename__ = "swe_session"
    id = db.Column(db.Integer, primary_key=True, autoincrement=True)
    token = db.Column(UUID(as_uuid=True), unique=True, default=uuid.uuid4)
    issued_at = db.Column(db.DateTime, nullable=False, server_default=func.now())
    expires_at = db.Column(db.DateTime, nullable=False)
    user_id = db.Column(db.Integer(), db.ForeignKey("swe_user.id"))

    def __init__(self, user_id):
        self.user_id = user_id
        # https://stackoverflow.com/questions/2780897/python-summing-up-time
        self.expires_at = datetime.datetime.utcnow() + datetime.timedelta(hours=24, minutes=0, seconds=0)

    def is_expired(self):
        return self.expires_at < datetime.datetime.utcnow()

swe_posts_tags = db.Table('swe_posts_tags',
    db.Column('post_id', db.Integer, db.ForeignKey('swe_post.id')),
    db.Column('tag_id', db.Integer, db.ForeignKey('swe_tag.id'))
)

class Tag(db.Model, Serializer):
    __tablename__ = "swe_tag"

    id = db.Column(db.Integer, primary_key=True, autoincrement=True)
    name = db.Column(db.String(64), unique=True, nullable=False)
    created_at = db.Column(db.DateTime, nullable=False, server_default=func.now())
    # posts = db.relationship('Post', secondary=posts_tags, backref=db.backref('tags', lazy='dynamic'))

    def __init__(self, tag_name):
        self.name = str(tag_name)

    def is_exist(tag_name):
        try:
            tag = Tag.query.filter_by(name=tag_name).one()
            return True
        except Exception as ex:
            if str(ex).startswith("No row was found for one()"):
                return False
            raise Exception(str(ex))

    def get(tag_name):
        try:
            tag = Tag.query.filter_by(name=tag_name).one()
            return tag
        except Exception as ex:
            if str(ex).startswith("No row was found for one()"):
                return Tag(tag_name)
            raise Exception(str(ex))

class Post(db.Model, Serializer):
    __tablename__ = "swe_post"

    id = db.Column(db.Integer, primary_key=True, autoincrement=True)
    uuid = db.Column(UUID(as_uuid=True), unique=True, default=uuid.uuid4)
    author = db.Column(db.Integer(), db.ForeignKey('swe_user.id'))  # Foreign key

    @declared_attr
    def tags(cls):
        # The first arg is a class name, the backref is a column name
        return db.relationship(
            "Tag",
            secondary=swe_tags_posts,
            backref=db.backref("posts", lazy="dynamic"),
        )

    tags = db.relationship('Tag', secondary=swe_posts_tags, backref=db.backref('posts', lazy='dynamic'))
    is_draft = db.Column(db.Boolean(), nullable=False, default=True)
    title = db.Column(db.String(64), unique=True, nullable=False)
    description = db.Column(db.String(255))
    content = db.Column(db.Text(), nullable=False)
    created_at = db.Column(db.DateTime, nullable=False, server_default=func.now())
    update_on = db.Column(db.DateTime, nullable=False, server_default=func.now(), onupdate=datetime.datetime.utcnow)

    def __init__(self, title, author, description, content, tags, is_draft=True):
        self.title = title
        self.author = author
        self.description = description
        self.content = content
        self.is_draft = is_draft

        for tag in tags.split(','):
            self.tags.append(Tag.get(tag))

    def update(self, title, author, description, content, tags, is_draft):
        self.title = title
        self.author = author
        self.description = description
        self.content = content
        self.is_draft = is_draft

        for tag in tags.split(','):
            self.tags.append(Tag.get(tag))

def reset_counter_id(table_name):

    sql = "DO $$ DECLARE maxid integer; BEGIN SELECT 1 + (SELECT COALESCE(MAX(id), 0) FROM " + table_name + " INTO maxid); EXECUTE 'ALTER SEQUENCE " + table_name + "_id_seq RESTART WITH ' || maxid; END; $$;"

    # pip install psycopg2-binary
    import psycopg2
    conn = psycopg2.connect(dbname='postgres', user='postgres', password='example', host='localhost', port="5432")
    cursor = conn.cursor()
    cursor.execute(sql)
    cursor.close()
    conn.commit()
    conn.close()

def basic_auth(f):
    # https://github.com/jpvanhal/flask-basicauth/blob/master/flask_basicauth.py
    @wraps(f)
    def decorated(*args, **kwargs):

        # Getting token from HTTP header
        username = None
        password = None

        auth = request.authorization
        if auth and auth.type == 'basic':
            try:
                user = User.query.filter_by(email=auth.username).one()
            except Exception as ex:
                if str(ex).startswith("No row was found for one()"):
                    return jsonify({"message": "No user found by username!"}), 400
                return jsonify({"message": "Some error has corrupted in the user request! " + str(ex)}), 400
            if user.check_password(auth.password):
                try:
                    new_session = Session(user.id)
                except Exception as ex:
                    if str(ex).startswith("400 Bad Request"):
                        return jsonify({"message": "400 Bad Request"}), 400
                    else:
                        return jsonify({"message": str(ex)}), 500

                # Saving the user object to DB
                try:
                    db.session.add(new_session)
                    db.session.commit()
                except Exception as ex:
                    db.session.rollback()
                    db.session.flush()
                    if str(ex).startswith("(psycopg2.errors.UniqueViolation)"):
                        return jsonify({"message":"Error: Some value is not unique"}), 400
                    if str(ex).startswith("(psycopg2.errors.NotNullViolation)"):
                        return jsonify({"message":"Error: Some value is null"}), 400
                    return jsonify({"message":str(ex)}), 500

                # return Response (
                #     status=200,
                #     headers={"x-access-token": str(new_session.token)}
                # )
                return jsonify({"x-access-token": str(new_session.token)}), 200
                # return f(user, *args, **kwargs)
            else:
                return jsonify({"message": "Password is incorrect!"}), 400
        else:
            # https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/WWW-Authenticate
            # https://efim360.ru/rfc-2617-http-autentifikatsiya-bazovaya-i-daydzhest-autentifikatsiya/
            return Response (
                status=401,
                headers={'WWW-Authenticate': 'Basic realm="Access to the user token provide by Basic auth", charset="UTF-8"'}
            )

    return decorated

def token_auth(f):
    # https://docs.python.org/3/library/uuid.html
    # https://docs-python.ru/standart-library/modul-uuid-python/
    # https://bukkit.org/threads/best-way-to-check-if-a-string-is-a-uuid.258625/
    # https://python.hotexamples.com/ru/examples/codalab.lib.spec_util/-/check_uuid/python-check_uuid-function-examples.html
    # https://pynative.com/python-uuid-module-to-generate-universally-unique-identifiers/

    @wraps(f)
    def decorated(*args, **kwargs):

        # Getting token from HTTP header
        token = None
        if "x-access-token" in request.headers:
            token = request.headers["x-access-token"]
        if not token:
            return jsonify({"message":"Token is missing!" + str(token)}), 401

        try:
            # Taking session by token
            session = Session.query.filter_by(token=token).one()

        except Exception as ex:
            if str(ex).startswith("(psycopg2.errors.InvalidTextRepresentation)"):
                # it is needed to move above for checking token before request
                # if not type(token) is type(uuid):
                return jsonify({'message': 'Token has a bad format! Use UUID format. Your token now is: ' + str(token)}), 401

            if str(ex).startswith("No row was found for one()"):
                return jsonify({"message": "Token is invalid!"}), 400

            return jsonify({'message': 'Error with request data by token! ' + str(token), 'error': str(ex)}), 401

        # Check session
        if session.is_expired():
            return jsonify({"message": "Token is expired!"}), 401
        else:
            current_user = session.user

        return f(current_user, *args, **kwargs)
    return decorated

@app.route('/api/v1/account', methods=['GET'])
@token_auth
def temp(current_user):
    return jsonify({"message": "This is temp callback. It will consist: login (basic), auth (token / session cookie), logout, reset, register, verify, 2fa-sms, 2fa-app, oauth, remember_me, capcha, perm-model (permisions), safety pass keeping", "current_user": str(current_user.fullname)}), 500

@app.route('/api/v1/login', methods=['GET'])
@basic_auth
def temp2(current_user):
    return jsonify({"message": "This is temp2 callback. It will consist: login (basic), auth (token / session cookie), logout, reset, register, verify, 2fa-sms, 2fa-app, oauth, remember_me, capcha, perm-model (permisions), safety pass keeping", "current_user": str(current_user.fullname), "admin": str(current_user.is_admin())}), 500

@app.route('/api/v1/users', methods=['GET'])
def user_showall():
    # https://medium.com/@erdoganyesil/typeerror-object-of-type-is-not-json-serializable-6230ccc74975
    try:
        users = User.query.all()
        users = User.serialize_list(users)
        return jsonify(users), 200
    except Exception as ex:
        return jsonify({"message": str(ex)}), 500

@app.route('/api/v1/users/<int:id>', methods=['GET'])
def user_show(id):
    user = User.query.filter_by(id = id).first()
    if user == None:
        user = {"message":"No user found by the id"}
        return jsonify(user), 404
    else:
        user = user.serialize()
        return jsonify(user), 200

@app.route('/api/v1/users', methods=['POST'])
def user_create():
    # https://stackoverflow.com/questions/10434599/get-the-data-received-in-a-flask-request

    # Creating an user object
    try:
        with db.session.no_autoflush:
            # https://fixmypc.ru/post/udalenie-i-formatirovanie-probelov-v-strokakh-s-python/
            # https://askdev.ru/q/kak-preobrazovat-stroku-v-nizhniy-registr-v-python-289/
            new_user = User(
                request.args.get("fullname", '').strip(),
                request.args.get("email", '').strip().lower(),
                request.args.get("perms", '').replace(' ', '').lower(),
                request.args.get("password", ''))
    except Exception as ex:
        if str(ex).startswith("400 Bad Request"):
            return jsonify({"message": "400 Bad Request", "more": str(ex)}), 400
        else:
            return jsonify({"message": str(ex)}), 500

    # Saving the user object to DB
    try:
        db.session.add(new_user)
        db.session.commit()
    except Exception as ex:
        db.session.rollback()
        reset_counter_id("swe_user")
        reset_counter_id("swe_perm")

        if str(ex).startswith("(psycopg2.errors.UniqueViolation)"):
            return jsonify({"message": "Error: Some value is not unique.", "more": str(ex)}), 400
        if str(ex).startswith("(psycopg2.errors.NotNullViolation)"):
            return jsonify({"message": "Error: Some value is null", "more": str(ex)}), 400
        return jsonify({"message":str(ex)}), 500

    id = new_user.id

    # Printing the new user object from DB
    user = User.query.filter_by(id = id).one()
    user = user.serialize()
    # print(str(user)) # DEBUG
    # print(type(user['perms'][0]).__name__)
    # user['perms'] = Perm.serialize_list(user['perms'])
    try:
        return jsonify(user), 201
    except Exception as ex:
        return jsonify({"message":str(ex)}), 500

@app.route('/api/v1/users/<int:id>', methods=['PUT'])
def user_update(id):
    try:
        user = User.query.filter_by(id = id).one()
        user.name = request.args.get("fullname", '').strip()
        user.email = request.args.get("email", '').strip().lower()
        user.email = request.args.get("perms", '').replace(' ', '').lower()
        db.session.add(user)
        db.session.commit()

        data = User.query.filter_by(id = id).one()
        data = data.serialize()
        return jsonify(data), 200
    except Exception as ex:
        db.session.rollback()
        db.session.flush()
        return jsonify({"message":"ID does not exist", "error": str(ex)}), 404

@app.route('/api/v1/users/<int:id>', methods=['DELETE'])
def user_delete(id):
    try:
        user = User.query.filter_by(id = id).one()
        db.session.delete(user)
        db.session.commit()
        return jsonify({"message":"User was removed"}), 201
    except Exception as ex:
        db.session.rollback()
        db.session.flush()
        return jsonify({"message":"ID does not exist", "error": str(ex)}), 404

@app.route('/api/v1/posts', methods=['GET'])
def post_showall():
    try:
        posts = Post.query.all()
        posts = Post.serialize_list(posts)
        return jsonify(posts), 200
    except Exception as ex:
        return jsonify({"message": str(ex)}), 500

@app.route('/api/v1/posts/<int:id>', methods=['GET'])
def post_show(id):
    post = Post.query.filter_by(id = id).first()
    if post == None:
        post = {"message":"No post found by the id"}
        return jsonify(post), 404
    else:
        post = post.serialize()
        return jsonify(post), 200

@app.route('/api/v1/posts', methods=['POST'])
def post_create():
    # author = "current_user" # Temporary
    author = 1
    try:
        with db.session.no_autoflush:
            new_post = Post(
                request.args.get("title", '').strip(),
                author,
                request.args.get("description", '').strip(),
                request.args.get("content", ''),
                request.args.get("tags", '').replace(' ', '').lower(),
                bool(request.args.get("is_draft", True))
            )
    except Exception as ex:
        if str(ex).startswith("400 Bad Request"):
            return jsonify({"message": "400 Bad Request", "more": str(ex)}), 400
        else:
            return jsonify({"message": str(ex)}), 500

    # Saving the post object to DB
    try:
        db.session.add(new_post)
        db.session.commit()
    except Exception as ex:
        db.session.rollback()
        reset_counter_id("swe_post")
        reset_counter_id("swe_tag")

        if str(ex).startswith("(psycopg2.errors.UniqueViolation)"):
            return jsonify({"message": "Error: Some value is not unique", "more": str(ex)}), 400
        if str(ex).startswith("(psycopg2.errors.NotNullViolation)"):
            return jsonify({"message": "Error: Some value is null", "more": str(ex)}), 400
        if str(ex).startswith("(psycopg2.errors.ForeignKeyViolation) insert or update on table \"swe_post\" violates foreign key constraint \"swe_post_author_fkey\"\n"):
            return jsonify({"message": "Error: User doesn't exist!", "more": str(ex)}), 400
        return jsonify({"message": str(ex)}), 500

    id = new_post.id

    # Printing the new post object from DB
    post = Post.query.get(id)
    if post == None:
        return jsonify({"message": "Element with that ID doesn't exist in DB."}), 500
    post = post.serialize()
    # print(str(post)) # DEBUG
    # print(type(post['perms'][0]).__name__)
    # post['perms'] = Perm.serialize_list(post['perms'])
    try:
        return jsonify(post), 201
    except Exception as ex:
        return jsonify({"message":str(ex)}), 500

@app.route('/api/v1/posts/<int:id>', methods=['PUT'])
def post_update(id):
    try:
        post = Post.query.filter_by(id = id).one()

        post.name = request.args.get("title", '').strip()
        post.author = "current_user"
        post.description = request.args.get("description", '').strip()
        post.content = request.args.get("content", '')
        post.tags = request.args.get("tags", '').replace(' ', '').lower()
        post.is_draft = request.args.get("is_draft", True)

        db.session.add(post)
        db.session.commit()

        data = Post.query.filter_by(id = id).one()
        data = data.serialize()
        return jsonify(data), 200
    except Exception as ex:
        db.session.rollback()
        db.session.flush()
        return jsonify({"message":"ID does not exist", "error": str(ex)}), 404

@app.route('/api/v1/posts/<int:id>', methods=['DELETE'])
def post_delete(id):
    try:
        post = Post.query.filter_by(id = id).one()
        db.session.delete(post)
        db.session.commit()
        return jsonify({"message":"Post was removed"}), 201
    except Exception as ex:
        db.session.rollback()
        db.session.flush()
        return jsonify({"message":"ID does not exist", "error": str(ex)}), 404

if __name__ == '__main__':
    db.drop_all()
    db.create_all()
    app.debug = True  # enables auto reload during development
    app.run()
