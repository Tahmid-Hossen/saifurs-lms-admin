
# Project Title

ALESHA TECH - ALESHA TECH - LMS 
######LEARNING MANAGEMENT SYSTEM

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

## Installation

Download or clone the code from repository.
Unzip the zip file or Run this command to clone

    git clone https://gitlab.aleshatechdev.com/ishtiaque/aleshalms.git


Open browser; goto [localhost/phpmyadmin](http://localhost/phpmyadmin).

Create a database with name **alesha_tech_lms** and import the file **alesha_tech_lms.sql** in that database or run 
    
    php artisan migrate:refresh --seed

Copy the remaining code into your root directory:

for example, for windows

**WAMP : /wamp/www/tech-lms-back-end**

OR

**XAMPP : /xampp/htdocs/tech-lms-back-end**

OR

**DOCKER :**

### Prerequisites

What things you need to install the software and how to install them


## Requirements

      - PHP version: 7.3 or newer
      - MySQL database (or access to create one) version: 5.7 or newer
      - MySQLi module for PHP
      - GD module for PHP


## How to install        
 
Go to tech-lms-back-end folder
    
    cd tech-lms-back-end
    
Pull the docker image
    
    docker pull tomsik68/xampp
    
Run the container
    
    docker run --name alesha-tech-lms -p 5002:22 -p 5003:80 -d -v /path/to/your/app/tech-lms-back-end:/www tomsik68/xampp:8

MySQL Details

      - MySQL Username = root
    
      - MySQL Password = 
    
      - MySQL Database = alesha_tech_lms

then

import database

      localhost:5003/phpmyadmin    
    
    
## For Upload Folder permission

      - sudo chgrp -R www-data storage  /path/to/your/app/public/upload/images/profile_image
    
      - sudo chmod -R ug+rwx  storage  /path/to/your/app/public/upload/images/content
    
      - sudo chmod -R ug+rwx  storage  /path/to/your/app/public/upload/images/ads
    
      - sudo chmod -R ug+rwx  storage  /path/to/your/app/public/upload/videos/content

      - sudo chmod -R ug+rwx  storage  /path/to/your/app/public/upload/videos/ads

## Rename Some file
    LINUX
      - cd www
      - cp index.php.example index.php
      - cp .htaccess.example .htaccess
      - cd public
      - cp index.php.example index.php
      - cp .htaccess.example .htaccess

    WINDOWS
      - root folder
      - copy index.php.example index.php
      - copy .htaccess.example .htaccess
      - cd public
      - copy index.php.example index.php
      - copy .htaccess.example .htaccess
      - cd config
      - copy app.php.example app.php
      - copy database.php.example database.php

## Base URL

This is the current Base URL

    http://localhost:5003/www
    
    
## Now login with

Super Admin: 

    http://localhost:5003/www/
    8801614000000 / 123456
    
# Note: Check GD library installed. Try to upload a image.


#         dd(\Route::getCurrentRoute()->getName());

# For Hafiz Only
            "@php -r \"file_exists('config/app.php.example') || copy('config/app.php.example', 'config/app.php');\"",
            "@php -r \"file_exists('config/database.php.example') || copy('config/database.php.example', 'config/database.php');\"",
            "@php -r \"file_exists('config/notification.php.example') || copy('config/notification.php.example', 'config/notification.php');\"",
            "@php -r \"file_exists('public/.htaccess.example') || copy('public/.htaccess.example', 'public/.htaccess');\"",
            "@php -r \"file_exists('public/index.php.example') || copy('public/index.php.example', 'public/index.php');\"",
            "@php -r \"file_exists('.htaccess.example') || copy('.htaccess.example', '.htaccess');\"",
            "@php -r \"file_exists('index.php.example') || copy('index.php.example', 'index.php');\""


# migration alternative 
https://laravel.com/docs/8.x/migrations#squashing-migrations


Model namespace
``` use Kyslik\ColumnSortable\Sortable; ```
inside model
```use Sortable;```
