# Task Management application using local database or redmine for storage tasks
- PR: https://github.com/skthon/laravelvue/pull/3
- Demos
    -
    - 

# Table of Contents
- [Requirements and Installation](#requirements-and-installation)
- [Tests](#tests)
- [Known Issues](#known-issues)

# Requirements and Installation
- Docker & Docker compose
    - PHP 8.1
    - Apache web server
    - Mysql 8.0
    - Composer
    - Node Js
- Clone the code repository
```
git clone https://github.com/skthon/laravelvue.git
```
- After cloning, Run the below commands to setup the project
```
# Creates the app, db images and launches the containers
docker-compose up -d

# navigate to the app container
docker exec -it bloomex bash

# Go to project directory and run the composer, generate app key
composer install
php artisan key:generate

# Copy the environment file
cp .env.example .env

# Edit the .env file to toggle between storages
TASK_STORAGE=redmine
#TASK_STORAGE=local
REDMINE_URL=http://host.docker.internal:8080
REDMINE_API_KEY=f294b9b5ef87f984889dd4185c8b40a357e05f8d
REDMINE_PROJECT_ID=3

# clear the cache and run the migrations
php artisan config:clear
php artisan migrate

# Run the tests
php artisan test
```

# Tests
$ php artisan test
```
```

# Known Issues


Update admin account
Setup default configuration

Create a project with an identifier

setup api key
Enable REST API in Administration -> Settings -> API. Then, authentication can be done in 2 different ways:
passed in as a "X-Redmine-API-Key" HTTP header (added in Redmine 1.1.0)
