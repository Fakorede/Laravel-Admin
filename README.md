# Laravel Admin App

> A simple admin app built to implement certain functionalities 


## API Features

- Pagination
- API Auth with Laravel Passport
- Protected Routes
- Roles and Permissions
- Exporting to CSV
- Charts for Analytics
- Product Orders and Image Uploads
- Swagger Documentation
## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

## Installation

Clone

```
git clone https://github.com/moshoodfakorede/Laravel-Admin.git
```

After cloning the application, you need to install it's dependencies.

```
$ cd Laravel-Admin
$ composer install
```

## Setup

When you are done with installation, copy the .env.example file to .env

```
$ cp .env.example .env
```

Generate the application key

```
$ php artisan key:generate
```

Create database connection

```
DB_DATABASE=your_db_name
DB_USERNAME=your_db_username
DB_PASSWORD=your_db_password
```

Run database migrations

```
$ php artisan migrate
```

Run command to create passport encryption keys

```
php artisan passport:install
```

Seed Database

```
$ php artisan db:seed
```

Run the app

```
$ php artisan serve
```

## API Documentation

This is accessible at `http://localhost:8000/api/documentation`

To generate a token to test the api, run the command:

```
$ php artisan token:generate {id}
```

where `id` represents a User ID (the db seed creates 30 users, so this can range from 1-30).

## Built With

-   Laravel - The PHP framework for building the API endpoints needed for the application.
-   Vue - The Progressive JavaScript Framework for building the interactive interfaces.
