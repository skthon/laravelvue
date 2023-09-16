# Task Management application using local database or redmine for storage tasks
- PR: https://github.com/skthon/laravelvue/pull/3
- Demo: https://drive.google.com/file/d/1gRXppUDcW-YVwQghuO2tsgKGHfPucmD6/view?usp=sharing
- Screenshots
<img width="1503" alt="Screenshot 2023-09-15 at 10 38 05 PM" src="https://github.com/skthon/laravelvue/assets/16775059/aae79bac-e1c1-4e47-815a-f7a20be63fac">
<img width="1090" alt="Screenshot 2023-09-15 at 10 12 00 PM" src="https://github.com/skthon/laravelvue/assets/16775059/80cadbb8-5de9-4711-9c37-0db5f2469a78">


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

# install package dependencies
npm install
npm run build
```


- Go to redmine application, login with below credentials and add default configuration data
    - username: admin, password: admin
- Navigate to administration page, Below message will be shown and load the default configuration
- Navigate to http://localhost:8080/projects and click on New Project button on right side
- Create a new project named 'bloomex' and once created you should be able to create new issue when navigated to the project
- Now we need to save these two fields to configure in the application
```
# Get the project id which can be fetched when navigated to the bloomex project
REDMINE_PROJECT_ID=1
 
# Go to http://localhost:8080/settings?tab=api page and enable REST API web service

# Now go to http://localhost:8080/my/account and on right side we should be able to see an access key
REDMINE_API_KEY=d4f6fd2e2666b76b14da846af16b2b6c09f5ea37

# Back to the web application
docker exec -it bloomex bash

# Run the migrations for tasks table
php artisan migrate

# Copy the environment file
cp .env.example .env

# update the .env file
TASK_STORAGE=redmine
#TASK_STORAGE=local
REDMINE_URL=http://host.docker.internal:8080
REDMINE_API_KEY=d4f6fd2e2666b76b14da846af16b2b6c09f5ea37
REDMINE_PROJECT_ID=1

# To clear the cache
php artisan config:clear
```

- Navigate to http://localhost:8000 and you can start creating tasks, delete tasks and viewing them.
- To toggle between local database and redmine as storage, navigate to .env and update `TASK_STORAGE`

# Tests
```
# create testing environment
docker exec app -it bash

# copy the env file
cp .env .env.testing

# modify the database
DB_DATABASE=bloomex_test

# Clear the config and Run the test database migrations
php artisan config:clear
php artisan migrate --env=testing

# Now run the tests
php artisan test
   PASS  Tests\Unit\ExampleTest
  ✓ that true is true

   PASS  Tests\Unit\TaskManagers\LocalTaskManagerTest
  ✓ create task
  ✓ update task
  ✓ delete task
  ✓ list tasks
  ✓ get task

   PASS  Tests\Feature\ExampleTest
  ✓ the application returns a successful response

  Tests:  7 passed
  Time:   0.70s
```

# Known Issues

- Pending unit tests for RedmineTaskManager class
- UI mobile view shows a scrollable bar
- Currently the frontend doesn't have update task action, viewing the task, create form doesn't have start data and due date inputs.
