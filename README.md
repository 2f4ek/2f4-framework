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

## Running Migration

```bash
php bin/migrations.php
```

## Registering Routes

To register a new route, follow these steps:

1. Open the `config/routes.php` file.
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
   If you need to skip middleware you can add specific parameter to the routes array:
   ```php
       '/user' => [
           'GET' => ['App\Controller\UserController', 'getUser', 'middleware' => false],
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

## Running Tests

### Behat Tests
Ensure that any necessary environment is properly configured before running Behat tests. This includes any local 
servers or database configurations.

```bash 
    vendor/bin/behat
```
This will execute all the feature tests located in the features/ directory.

### Unit tests
Unit tests focus on individual components (classes, functions) to ensure they behave as expected in isolation.
Run unit tests using PHPUnit:

```bash 
    vendor/bin/phpunit
```

For a specific unit test file:

```bash 
    vendor/bin/phpunit tests/Unit/SpecificTest.php
```

To generate reports:

```bash 
    php -dxdebug.mode=coverage vendor/bin/phpunit --coverage-html coverage/html
```

## Templating Engine

### HTML Responses

To return an HTML response, use the `TemplateEngine` class to render a template and pass it to the `Response::html` method.

Example:

```php
$html = $this->templateEngine->render('example', [
    'title' => 'Test Page',
    'heading' => 'Welcome to the Test Page',
    'content' => 'This is a simple test page.'
]);

return Response::html($html);
```

### JSON Responses

To return a JSON response, use the Response::json method and pass an array of data.

Example:

```php
$data = [
    'message' => 'This is a JSON response',
    'status' => 'success'
];

return Response::json($data);
```

### Security Measures

All variables passed to templates are escaped using htmlspecialchars to prevent XSS attacks.
The template engine uses EXTR_SKIP to avoid overwriting existing variables.

### Nested Templates

The template engine supports nested templates by including other template files within a template.

Example:
```php
<?php include 'header.php'; ?>
<h1><?= htmlspecialchars($heading, ENT_QUOTES, 'UTF-8') ?></h1>
<?php include 'footer.php'; ?>
```