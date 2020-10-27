from sqlalchemy.inspection import inspect
from flask_sqlalchemy import SQLAlchemy

# SQLAlchemy
# https://github.com/sgangopadhyay/python-rest-api/blob/master/restapi.py

db = SQLAlchemy()

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
        return {c: getattr(self, c) for c in inspect(self).attrs.keys()}

    @staticmethod
    def serialize_list(l):
        return [m.serialize() for m in l]

class Role(db.Model):
    __tablename__ = 'role'
    id = db.Column(db.Integer, primary_key = True)
    name = db.Column(db.String(50))

class User(db.Model, Serializer):
    __tablename__ = 'user'

    id = db.Column(db.Integer, db.Sequence('users_id_seq', start=1, increment=1), primary_key = True, autoincrement=True)

    username = db.Column(db.String(64), nullable=False)
    email = db.Column(db.String(64), unique=True, nullable=False)

    role = db.Column(db.Integer(), db.ForeignKey('roles.id'), nullable=False)
    password_hash = db.Column(db.String(64), unique=True, nullable=False)
    active = Column(Boolean(), nullable=False)

    def serialize(self):
        d = Serializer.serialize(self)
        del d['pbkdf2']
        return d

    # def __repr__(self):
    #     return self.serialize()

    def __init__(self, name, email, role, password):
        self.name = name
        self.email = email
        self.role = role
        self.pbkdf2 = password

class Tag(db.Model):
    __tablename__ = 'tags'
    id = db.Column(db.Integer, primary_key = True)
    name = db.Column(db.String(50))
    # нужно реализовать один ко многим связь с PostsModel

class Session(db.Model):
    __tablename__ = 'sessions'
    token = db.Column(db.Integer, primary_key = True)
    created_at = db.Column(db.DateTime)
    expired_at = db.Column(db.DateTime)
    user = db.Column(db.Integer(), db.ForeignKey('users.id'))

class Post(db.Model):
    __tablename__ = 'posts'
    id = db.Column(db.Integer, primary_key = True)
    title = db.Column(db.String(50))
    preview = db.Column(db.String(50))
    text = db.Column(db.String(50))
    created_at = db.Column(db.DateTime)
    author = db.Column(db.Integer(), db.ForeignKey('users.id'))
