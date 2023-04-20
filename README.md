# Fruits App

This is a simple web application built with Symfony and Vue.js that allows users to view and search for fruits, as well as mark their favorite fruits.

## Installation

1. Clone the repository: `git clone https://github.com/huseynrasulov/fruits-app.git`
2. Install PHP dependencies: `composer install`
3. Install JavaScript dependencies: `npm install`
4. Connect to the database from env file, change ADMIN_EMAIL and MAILER_DSN
5. Run database migrations: `php bin/console doctrine:migrations:migrate` (1:`bin/console make:migration`)

## Usage

To start the development server, run:

```
npm run dev-server
```

This will start a local development server at `http://localhost:8080` where you can access the Fruits App.

## Tests

To run the tests, run:

```
php bin/phpunit
```
