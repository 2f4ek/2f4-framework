<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Framework2f4\Container;
use Psr\Log\LoggerInterface;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$container = new Container();

$logger = new Logger('default_logger');
$logger->pushHandler(new StreamHandler(__DIR__ . '/../logs/app.log', Logger::DEBUG));
$container->set(LoggerInterface::class, $logger);

return $container;