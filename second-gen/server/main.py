#! /usr/bin/env python3

from flask import Flask
from flask_sqlalchemy import SQLAlchemy
from flask_restful import Api
# from flask_security import
import json

from api_resources import Users

app = Flask(__name__)
# https://pythonru.com/uroki/14-sozdanie-baz-dannyh-vo-flask
app.config['SQLALCHEMY_DATABASE_URI'] = 'postgresql://postgres:example@localhost:5432/postgres'

db = SQLAlchemy(app)
api = Api(app)

api.add_resource(Users, "/api/v0.1/users", "/api/v0.1/users/", "/api/v0.1/users/<int:id>")

if __name__ == '__main__':
    db.create_all()
    app.debug = True  # enables auto reload during development
    app.run()

