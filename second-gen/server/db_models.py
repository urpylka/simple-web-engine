from sqlalchemy.inspection import inspect
from flask_sqlalchemy import SQLAlchemy

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

class RolesModel(db.Model):
    __tablename__ = 'roles'
    id = db.Column(db.Integer, primary_key = True)
    name = db.Column(db.String(50))

class TagsModel(db.Model):
    __tablename__ = 'tags'
    id = db.Column(db.Integer, primary_key = True)
    name = db.Column(db.String(50))
    # нужно реализовать один ко многим связь с PostsModel

class SessionsModel(db.Model):
    __tablename__ = 'sessions'
    token = db.Column(db.Integer, primary_key = True)
    created_at = db.Column(db.DateTime)
    expired_at = db.Column(db.DateTime)
    user = db.Column(db.Integer(), db.ForeignKey('users.id'))

class UsersModel(db.Model, Serializer):
    # https://www.codementor.io/@olawalealadeusi896/restful-api-with-python-flask-framework-and-postgres-db-part-1-kbrwbygx5
    __tablename__ = 'users'
    id = db.Column(db.Integer, primary_key = True, nullable=False)
    name = db.Column(db.String(50), nullable=False)
    email = db.Column(db.String(50), unique=True, nullable=False)
    role = db.Column(db.Integer(), db.ForeignKey('roles.id'), nullable=False)
    pbkdf2 = db.Column(db.String(64), unique=True, nullable=False)

    def serialize(self):
        d = Serializer.serialize(self)
        del d['pbkdf2']
        return d

    # def __repr__(self):
    #     return self.serialize()

    def __init__(name, email, role, password):
        self.name = name
        self.email = email
        self.role = role
        self.pbkdf2 = password

class PostsModel(db.Model):
    __tablename__ = 'posts'
    id = db.Column(db.Integer, primary_key = True)
    title = db.Column(db.String(50))
    preview = db.Column(db.String(50))
    text = db.Column(db.String(50))
    created_at = db.Column(db.DateTime)
    author = db.Column(db.Integer(), db.ForeignKey('users.id'))
