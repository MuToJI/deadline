<?php namespace deadline;

use deadline\Controls;
use deadline\Lcs;

session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
define('SITE_URL', 'http://endline/index.php');
require 'vendor\autoload.php';
Lcs\connection(['host' => 'localhost', 'dbname' => 'blog', 'user' => 'root', 'password' => '', 'encoding' => 'utf8']);
Lcs\routes($_SERVER['REQUEST_URI'], [
    'home' => '\deadline\Controls\Home',
    'reg' => '\deadline\Controls\Registration',
    'login' => '\deadline\Controls\Login',
    'delete' => '\deadline\Controls\Delete',
    'save' => '\deadline\Controls\Save'
]);
