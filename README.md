# Custom PHP Framework

This document provides guidelines on how to work with the Framework2f4

## Getting Started

To set up the project, clone the repository and navigate into the project directory. 
Run `docker-compose up` to build and start the containers.
After this step you can access your app with localhost. 

## Installing Dependencies

Before running the application, you need to install the necessary PHP dependencies managed by Composer.
If you haven't already installed Composer, follow the instructions on the [Composer official website](https://getcomposer.org/download/).

Once Composer is installed, run the following command in the root directory of your project to install the dependencies:

```bash
composer install
```

## Registering Routes

To register a new route, follow these steps:

1. Open the `public/index.php` file.
2. Locate the `$routes` array.
3. Add a new entry to the array using the format:

   ```php
   '<path>' => [
       '<HTTP_METHOD>' => ['<ControllerClassName>', '<methodName>']
   ]
   ```
   
    For example, to add a new route for fetching user details via a GET request:

    ```php
    '/user' => [
        'GET' => ['App\Controller\UserController', 'getUser'],
        'POST' => ['App\Controller\UserController', 'createUser'],
        'PUT' => ['App\Controller\UserController', 'updateUser']
    ]
   ```

## Running Static Code Analyzers

### PHPStan
This command analyzes the code for potential errors and outputs a report detailing issues such
as type mismatches and method call errors.

```bash 
    vendor/bin/phpstan analyse
```

### Psalm
Psalm performs a static analysis of your codebase to detect type safety issues, possible bugs,
and suboptimal code patterns. The output includes a list of issues with suggested fixes.

```bash 
    vendor/bin/psalm
```

### Phan
Phan is a static analyzer focusing on PHP's type system and can detect issues related to type compatibility,
unused code, and more. The results will list detected issues along with their severity and location in the code.
```bash 
    vendor/bin/phan --allow-polyfill-parser
```