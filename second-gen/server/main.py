#! /usr/bin/env python3

from flask import Flask, jsonify, request
from flask_sqlalchemy import SQLAlchemy
from flask_restful import Api
# from flask_security import
import psycopg2

from db_models import Serializer, Role, Tag, Session, User, Post

app = Flask(__name__)
# https://pythonru.com/uroki/14-sozdanie-baz-dannyh-vo-flask
app.config['SQLALCHEMY_DATABASE_URI'] = 'postgresql://postgres:example@localhost:5432/postgres'
db = SQLAlchemy(app)

@app.route('/api/v1/account', methods=['GET'])
def temp():
    return jsonify({"message": "This is temp callback. It will consist: login (basic), auth (token / session cookie), logout, reset, register, verify, 2fa-sms, 2fa-app, oauth, remember_me, capcha, role-model (permisions), safety pass keeping"}), 500

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
    try:
        new_user = User(\
            request.args.get("name", ''), \
            request.args.get("email", ''), \
            request.args.get("role", ''), \
            request.args.get("password", ''))
    except Exception as ex:
        if str(ex).startswith("400 Bad Request"):
            return jsonify({"message": "400 Bad Request"}), 400
        else:
            return jsonify({"message": str(ex)}), 500

    try:
        db.session.add(new_user)
        db.session.commit()
    except Exception as ex:
        db.session.rollback()
        db.session.flush()
        if str(ex).startswith("(psycopg2.errors.UniqueViolation)"):
            return jsonify({"message":"Error: Some value is not unique"}), 400
        if str(ex).startswith("(psycopg2.errors.NotNullViolation)"):
            return jsonify({"message":"Error: Some value is null"}), 400
        return jsonify({"message":str(ex)}), 500

    user = User.query.filter_by(id = new_user.id).first()
    user = user.serialize()
    return jsonify(data), 201

@app.route('/api/v1/users/<int:id>', methods=['PUT'])
def user_update(id):
    try:
        user = User.query.filter_by(id = id).first()
        user.name = request.args.get("name", '')
        user.email = request.args.get("email", '')
        db.session.add(user)
        db.session.commit()

        data = User.query.filter_by(id = id).first()
        return jsonify(data), 200
    except:
        db.session.rollback()
        db.session.flush()
        return jsonify({"message":"ID does not exist"}), 404

@app.route('/api/v1/users/<int:id>', methods=['DELETE'])
def user_delete(id):
    try:
        User.query.filter_by(id = id).delete()
        db.session.commit()
        return jsonify({"message":"User was removed"}), 201
    except:
        db.session.rollback()
        db.session.flush()
        return jsonify({"message":"ID does not exist"}), 404

if __name__ == '__main__':
    # db.drop_all()
    db.create_all()
    app.debug = True  # enables auto reload during development
    app.run()
