#! /usr/bin/env python3

from flask import Flask, jsonify
from flask_sqlalchemy import SQLAlchemy
from flask_restful import Api
# from flask_security import
import json

from db_models import Serializer, RolesModel, TagsModel, SessionsModel, UsersModel, PostsModel

app = Flask(__name__)
# https://pythonru.com/uroki/14-sozdanie-baz-dannyh-vo-flask
app.config['SQLALCHEMY_DATABASE_URI'] = 'postgresql://postgres:example@localhost:5432/postgres'
db = SQLAlchemy(app)

@app.route('/api/v0.1/users', methods=['GET'])
def user_showall():
    # https://medium.com/@erdoganyesil/typeerror-object-of-type-is-not-json-serializable-6230ccc74975
    data = UsersModel.query.all()
    data = UsersModel.serialize_list(data)
    return jsonify(data), 200

@app.route('/api/v0.1/users/<int:id>', methods=['GET'])
def user_show(id):
    data = UsersModel.query.filter_by(id = id).first()
    if data == None:
        data = {"message":"No user found by the id"}
        return data, 404
    else:
        data = data.serialize()
        return jsonify(data), 200

@app.route('/api/v0.1/users', methods=['POST'])
def user_create():
    parser = reqparse.RequestParser()
    parser.add_argument("name")
    parser.add_argument("email")
    parser.add_argument("role")
    parser.add_argument("pbkdf2")
    params = parser.parse_args()

    users_model = UsersModel(params["name"], params["email"], '')

    save_to_database = db.session
    try:
        save_to_database.add(users_model)
        save_to_database.commit()
    except Exception as ex:
        save_to_database.rollback()
        save_to_database.flush()
        return {"message":"User with this ID already exist", "error": str(ex)}, 500
    except psycopg2.errors.NotNullViolation as ex:
        save_to_database.rollback()
        save_to_database.flush()
        return {"message":"Error: Some value is null", "error": str(ex)}, 500

    id = users_model.id
    data = UsersModel.query.filter_by(id = id).first()
    data = data.serialize()
    return jsonify(data), 201

@app.route('/api/v0.1/users/<int:id>', methods=['PUT'])
def user_change(id):
    parser = reqparse.RequestParser()
    parser.add_argument("name")
    parser.add_argument("email")
    params = parser.parse_args()

    save_to_database = db.session
    try:
        user_model = UsersModel.query.filter_by(id = id).first()
        user_model.name = params["name"]
        user_model.email = params["email"]
        save_to_database.commit()

        data = UsersModel.query.filter_by(id = id).first()
        # return data, 200
        return data, 200
        # return {"id":data.id,"name":data.name,"email":data.email}, 200
    except:
        save_to_database.rollback()
        save_to_database.flush()
        return {"message":"ID does not exist"}, 404

@app.route('/api/v0.1/users/<int:id>', methods=['DELETE'])
def user_delete(id):
    parser = reqparse.RequestParser()
    parser.add_argument("name")
    params = parser.parse_args()

    save_to_database = db.session
    try:
        UsersModel.query.filter_by(id = id).delete()
        save_to_database.commit()
        return jsonify({"message":"User was removed"}), 201
    except:
        save_to_database.rollback()
        save_to_database.flush()
        return jsonify({"message":"ID does not exist"}), 404

if __name__ == '__main__':
    db.create_all()
    app.debug = True  # enables auto reload during development
    app.run()

