# PHP-MVC-Framework

## How to run:

- Clone the repo.
- Run `composer install` to install dependencies.
- Copy the .env.example file and rename it .env and add your environment variable in it.
- Create the database and run the `Database/Schema.sql` file to create the database.
- Inside the public folder run this command to serve the project  `php -S localhost:8080`  you can change the port as you prefer.
- Uncomment the `set_exception_handler` function in `public/index.php` file to display errors in development mode.

## Requirments 
- php: 8.1
- Mysql: 10.11


## Features:

- It follows the MVC pattern.
- Router with ability to make different route files. you need to call them in index.php file.Just follow the pattern there.
- Controller with ability to use method injection on its methods similar to Laravel.
- Model That represent the tables records.
- QueryBuilder.
- Request Class that can be extended to costume request like `MassDeleteRequest` and can be injected to a controller method.
- Request Validation : The Request Class has a function called validate where you can put your validation logic.  
  If you used method injection on a controller method and injected it with a class that inherit the Request class the router will get an instance of this Request and 
  call validate method on this class and if it returns true The router will call the target method otherwise it returns a response with the 
  appropriate error message.
- Response Class.
- Session Class that supports the flash session.
- Validator Class.
- It uses the twig template engin.
- It uses the DI Container of the laravel framework.
- Facade Class.
- Input Sanitizer Class that Sanitize input data from post, get ,cookie against malicious input.
- Die and dump helper function.
- Dump helper Function.
- And more....




## Live preview:

[I hope it still up.](https://scandiwebtaskassignment.000webhostapp.com/) Try to ues VPN if it does not open.

