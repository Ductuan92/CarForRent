# CarForRent
An application for renting car. User can rent cars after login. Only admin can add or remove cars 

Using MVC model to control the workflow between views and database. CarForRent is written by PHP and MySQL. This project apply many techniques that all frameworks use such as Router, Controller, View, Model, Service, Repository, Middleware, Access control list, and Validator. Besides, that, this project integrates with the S3 service of AWS Cloud to store files or images.

## Setup Environment
-Install Nginx in Ubuntu 20.04.

-Create an account to use the S3 service in AWS.
## Usage

- Clone project to local:

    ```bash
  git clone git@github.com:Ductuan92/carForRent.git
  ```
- Make a copy of the file `.env.example` and rename it to `.env`
- Edit all the parameters in `.env` corresponding to your environment
- Install Xdebug to generate test coverage:
- ```bash
  sudo apt-get install php-xdebug
  sudo apt-get install php-simplexml
    ```

- Install all necessary packages, and dependencies by using composer:

    ```bash
    composer install
    ```
