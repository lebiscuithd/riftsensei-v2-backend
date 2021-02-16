# Rift Sensei
## description
Laravel backend project for Riftsensei App for serving endpoints API that will be consumed by a frontend app.
## installation
***

Create a database with PhPmyAdmin called 'riftsensei'

***

Run in your terminal :

```bash
cp .env.example .env
````

It will create your .env file

Then modify your .env with your mysql parameters

***

STRIPE settings 
Head to your .env file and change the below field with your own keys:

```bash
STRIPE_KEY= "Your key"
STRIPE_SECRET= "Your key"
````

***

JWT settings
Head to your .env file and change the below field with your own key and secret:

```bash
JWT_SECRET= "Your secret"
JWT_TTL= "Up to you"
````

***

CHAT settings
Head to your .env file and change the below field with information related to your Pusher account:

```bash
PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1
````

***

\
Install the project librairies/dependencies :

```bash
composer install
npm install
````

***

Run the laravel migration for creating our users table with --seed to seed our tables with random datas :

```bash
php artisan migrate --seed
````

This command will generate data in the database, only for display on the app. 
In order to test the app, you will have to register and create your own account by heading to:

https://riftsensei-v2-frontend.vercel.app
***

\
Now let's serve the project

```bash 
php artisan serve
````

***

Our laravel project is now running with APIs endpoints that can be used by a separate frontend project. Do not forget to generate a laravel access key.

***

## Notice

This project is only for the backend of the app.

We will only use Laravel to create APIs.

You can find the frontend part, a vuejs cli project, here : https://github.com/lebiscuithd/riftsensei-v2-frontend
