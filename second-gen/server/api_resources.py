from flask_restful import Api, Resource, reqparse

from db_models import Serializer, RolesModel, TagsModel, SessionsModel, UsersModel, PostsModel

api = Api()

class Users(Resource):
    '''
    ## Flask RESTful
    https://flask-restful.readthedocs.io/en/latest/
    https://habr.com/en/company/skillbox/blog/464705

    ## Flask Security
    https://pythonhosted.org/Flask-Security/
    https://python-scripts.com/haslib-pbkdf2-check-password
    https://github.com/hypknowsys/Python-PBKDF2-Flask-Password-Encoder

    ## Token Authentication
    https://www.youtube.com/watch?v=WxGBoY5iNXY

    ## Flask httpauth
    https://habr.com/en/post/246699/
    '''
    def get(self, id=None):
        if id == None:
            # https://medium.com/@erdoganyesil/typeerror-object-of-type-is-not-json-serializable-6230ccc74975
            data = UsersModel.query.all()
            data = UsersModel.serialize_list(data)
            return data, 200
        else:
            data = UsersModel.query.filter_by(id = id).first()
            if data == None:
                data = {"message":"No user found by the id"}
            else:
                data = data.serialize()
            return data, 404

    def post(self):
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
        return data, 201

    def put(self, id):
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
            return jsonify(data), 200
            # return {"id":data.id,"name":data.name,"email":data.email}, 200
        except:
            save_to_database.rollback()
            save_to_database.flush()
            return jsonify({"message":"ID does not exist"}), 404

    def delete(self, id):

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
