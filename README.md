# Laravel Practical Test

## The Task: Custom Forms

You can follow the step following for the practical test

#### Backend APIs
- modify .env file (mail, db, key)
- **composer install**
- **npm install && npm run dev** (to run laravel ui)
- **php artisan queue:listen** (to send email)


#### APIs Docs Version 1

## Header Authentication : Bearer {token from register/login api response}
## Base Url : http://example.com/api

## POST Login API
- ** /v1/login **
- [] email
- [] password

## POST Register API
- ** /v1/register **
- [] name
- [] email
- [] password
- [] password_confirmation

## GET All Surveys
- ** /v1/surveys **

## GET Survey By Id
- ** /v1/surveys{survey_id} **

## POST Survey New Form
- ** /v1/surveys **
- [] title | string
- [] publish | boolean
- [] default_questions | array | enum(["name", "phone", "birth_date"])
- [] questions | array
    - [] name | string
    - [] type | enum(["text", "number", "date"])

## POST User submit Survey Form
- ** /v1/survey/answer **
- [] survey_id | numeric
- [] answers | array
    - [] survey_question_id | numeric
    - [] answer | text


#### Others
- refer to postman folder for api call reference
