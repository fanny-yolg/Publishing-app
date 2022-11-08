# Publishing APP

1. Clone Repository
2. Run "composer install"
3. Run "php artisan key:generate"
4. Set local env for database
4. Run "php artisan migrate"

# Backend

Initial Main Branch

# USER API

## CREATE

---

### Method POST (http://publishing-app.test/api/user)

### Request Header

> none

### Request Body

> email : <asset_email> <br>password: <asset_password> <br>name: <asset_name><br>

### Response (200)

> "status": true <br>"message": "<success_msg>" <br>data: <data_user_created>

### Response (400 - Bad Request)

> "msg": "<error_msg>"

---

<br>

## Login

---

### Method POST (http://publishing-app.test/api/login)
### Request Header

> none

### Request Body

> email : <asset_email> <br>password: <asset_password>

### Response (200)

> "status": true <br>"message": "<success_msg>" <br>data: "<your_token>"

### Response (400 - Bad Request)

> "msg": "<error_msg>"

---

<br>

## Logout

---

### Method POST (http://publishing-app.test/api/logout)
### Request Header

> Authorization: <bearer_your_token>

### Request Body

> none

### Response (200)

> "<success_msg>"

### Response (400 - Bad Request)

> "msg": "<error_msg>"

---

<br>

## Get All User

---

### Method GET (http://publishing-app.test/api/user)
### Request Header

> Authorization: <bearer_your_token>

### Request Body

> none

### Response (200)

> **User Table** <br>"email": "<asset_email>"<br> "password": "<asset_password>" <br> "name": "<asset_name>"

### Response (400 - Bad Request)

> "msg": "<error_msg>"

---

<br>

## Get A User

---

### Method GET (http://publishing-app.test/api/user/{id})
### Request Header

> Authorization: <bearer_your_token>

### Request Body

> none

### Response (200)

> **User Table** <br>"email": "<asset_email>"<br> "password": "<asset_password>" <br> "name": "<asset_name>"

### Response (400 - Bad Request)

> "msg": "<error_msg>"

---

<br>

## Delete User

---

### Method DELETE (http://publishing-app.test/api/user/{id})

### Request Header

> Authorization: <bearer_your_token>

### Request Body

> none

### Response (200)

> "status": true <br>"message": "<success_msg>"

### Response (400 - Bad Request)

> "msg": "<error_msg>"

---

<br>

## Update User

---

### Method PUT (http://publishing-app.test/api/user/{id})

### Request Header

> Authorization: <bearer_your_token>

### Request Body

> name : <asset_name> <br>email: <asset_email>

### Response (200)

> "status": true <br>"message": "<success_msg>" <br>"data": "email": "<asset_email>" "name": "<asset_name>" 
### Response (400 - Bad Request)

> "msg": "<error_msg>"

---

<br>

# POST API

## CREATE

---

### Method POST (http://publishing-app.test/api/post)

### Request Header

> Authorization: <bearer_your_token>

### Request Body

> title : <asset_title> <br>body: <asset_body>

### Response (200)

> "status": true <br>"message": "<success_msg>" <br>data: <data_post_created>

### Response (400 - Bad Request)

> "msg": "<error_msg>"

---

<br>

## UPDATE

---

### Method PUT (http://publishing-app.test/api/post/{id})

### Request Header

> Authorization: <bearer_your_token>

### Request Body

> title : <asset_title> <br>body: <asset_body>

### Response (200)

> "status": true <br>"message": "<success_msg>" <br>data: <data_post_updated>

### Response (400 - Bad Request)

> "msg": "<error_msg>"

---

<br>

## GET ALL

---

### Method GET (http://publishing-app.test/api/post)

### Request Header

> Authorization: <bearer_your_token>

### Request Body

> none

### Response (200)

> "status": true <br>"message": "<success_msg>" <br>data: <data_posts>

### Response (400 - Bad Request)

> "msg": "<error_msg>"

---

<br>

## GET ALL WITH COMMENT

---

### Method GET (http://publishing-app.test/api/post/{with_comments?})

### Request Header

> Authorization: <bearer_your_token>

### Request Body

> none

### Response (200)

> "status": true <br>"message": "<success_msg>" <br>data: <data_posts_with_comments>

### Response (400 - Bad Request)

> "msg": "<error_msg>"

---

<br>

## GET A POST

---

### Method GET (http://publishing-app.test/api/post/{id})

### Request Header

> Authorization: <bearer_your_token>

### Request Body

> none

### Response (200)

> "status": true <br>"message": "<success_msg>" <br>data: <data_posts_with_comments>

### Response (400 - Bad Request)

> "msg": "<error_msg>"

---

<br>

## DELETE A POST

---

### Method DELETE (http://publishing-app.test/api/post/{id})

### Request Header

> Authorization: <bearer_your_token>

### Request Body

> none

### Response (200)

> "status": true <br>"message": "<success_msg>"

### Response (400 - Bad Request)

> "msg": "<error_msg>"

---

<br>

# COMMENT API

## CREATE

---

### Method POST (http://publishing-app.test/api/comment)

### Request Header

> Authorization: <bearer_your_token>

### Request Body

> content : <asset_content> <br>post_id: <asset_post_id>

### Response (200)

> "status": true <br>"message": "<success_msg>" <br>data: <data_comment_created>

### Response (400 - Bad Request)

> "msg": "<error_msg>"

---

<br>

## UPDATE

---

### Method PUT (http://publishing-app.test/api/comment/{id})

### Request Header

> Authorization: <bearer_your_token>

### Request Body

> content : <asset_content> <br>post_id: <asset_post_id>

### Response (200)

> "status": true <br>"message": "<success_msg>" <br>data: <data_comment_updated>

### Response (400 - Bad Request)

> "msg": "<error_msg>"

---

<br>

## GET ALL

---

### Method GET (http://publishing-app.test/api/comment)

### Request Header

> Authorization: <bearer_your_token>

### Request Body

> none

### Response (200)

> "status": true <br>"message": "<success_msg>" <br>data: <data_comments>

### Response (400 - Bad Request)

> "msg": "<error_msg>"

---

<br>

## GET A COMMENT

---

### Method GET (http://publishing-app.test/api/comment/{id})

### Request Header

> Authorization: <bearer_your_token>

### Request Body

> none

### Response (200)

> "status": true <br>"message": "<success_msg>" <br>data: <data_comment>

### Response (400 - Bad Request)

> "msg": "<error_msg>"

---

<br>

## DELETE A POST

---

### Method DELETE (http://publishing-app.test/api/comment/{id})

### Request Header

> Authorization: <bearer_your_token>

### Request Body

> none

### Response (200)

> "status": true <br>"message": "<success_msg>"

### Response (400 - Bad Request)

> "msg": "<error_msg>"

---

<br>



