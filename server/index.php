<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

include_once 'Autoload.php';

use Server\APIEndpointController;

$api = new APIEndpointController();

$api->parseRequest();