#! /usr/bin/env python3

from flask import Flask, jsonify
from flask_sqlalchemy import SQLAlchemy
from flask_restful import Api, Resource, reqparse

app = Flask(__name__)
# https://pythonru.com/uroki/14-sozdanie-baz-dannyh-vo-flask
app.config['SQLALCHEMY_DATABASE_URI'] = 'postgresql://postgres:example@localhost:5432/postgres'
app.config['SECRET_KEY'] = 'i_love_pizza'

db = SQLAlchemy(app)

# https://habr.com/en/company/skillbox/blog/464705/
api = Api(app)

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
    created_at = db.Column(db.String(50))
    expired_at = db.Column(db.String(50))
    user = db.Column(db.Integer(), db.ForeignKey('users.id'))

class UsersModel(db.Model):
    __tablename__ = 'users'
    id = db.Column(db.Integer, primary_key = True)
    name = db.Column(db.String(50))
    email = db.Column(db.String(50))
    role = db.Column(db.Integer(), db.ForeignKey('roles.id'))

class PostsModel(db.Model):
    __tablename__ = 'posts'
    id = db.Column(db.Integer, primary_key = True)
    title = db.Column(db.String(50))
    preview = db.Column(db.String(50))
    text = db.Column(db.String(50))
    created_at = db.Column(db.String(50))
    author = db.Column(db.Integer(), db.ForeignKey('users.id'))

class Users(Resource):
    def get(self, id=0):
        try:
            if id == 0:
                data = UsersModel.query.all()
                print(data)
                return jsonify(data), 200
            else:
                data = UsersModel.query.filter_by(id = id).first()
                return jsonify(data), 200
        except:
            # нужно сделать проверку на наличие id
            data = {"message":"ID does not exist"}
            return jsonify(data), 404

    def post(self):
        parser = reqparse.RequestParser()
        parser.add_argument("name")
        parser.add_argument("email")
        parser.add_argument("role")
        parser.add_argument("pkfb2")
        params = parser.parse_args()

        users_model = UsersModel(name = params["name"], email = params["email"])

        save_to_database = db.session
        try:
            save_to_database.add(users_model)
            save_to_database.commit()
        except:
            save_to_database.rollback()
            save_to_database.flush()

        id = users_model.id
        data = UsersModel.query.filter_by(id = id).first()
        return jsonify({"id":data.id, "name":data.name, "email":data.email}), 201

    def put(self, id):
        parser = reqparse.RequestParser()
        parser.add_argument("author")
        parser.add_argument("quote")
        params = parser.parse_args()
        for quote in ai_quotes:
            if(id == quote["id"]):
                quote["author"] = params["author"]
                quote["quote"] = params["quote"]
                return quote, 200

        quote = {
            "id": id,
            "author": params["author"],
            "quote": params["quote"]
        }

        ai_quotes.append(quote)
        return quote, 201

    def delete(self, id):
        global ai_quotes
        ai_quotes = [qoute for qoute in ai_quotes if qoute["id"] != id]
        return f"Quote with id {id} is deleted.", 200

api.add_resource(Users, "/api/v0.1/users", "/api/v0.1/users/", "/api/v0.1/users/<int:id>")

if __name__ == '__main__':
    db.create_all()
    app.debug = True  # enables auto reload during development
    app.run()
