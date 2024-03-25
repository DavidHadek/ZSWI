<?php

////// connection consts for database ///////

use zswi\Controllers\AllTasksController;
use zswi\Controllers\AuthPageController;
use zswi\Controllers\IntroductionController;
use zswi\Views\View;

const DB_SERVER = "localhost";
const DB_NAME = "web";
const DB_USER = "root";
const DB_PASS = "";

define('ROOT', dirname(__FILE__) . DIRECTORY_SEPARATOR);
const APP = ROOT . 'app' . DIRECTORY_SEPARATOR;
const VIEW = APP . 'Views' . DIRECTORY_SEPARATOR;
const TWIG_TPL_DIR = VIEW . 'templates' . DIRECTORY_SEPARATOR;

const TABLE_USER = "user";
const TABLE_CLASS = "class";
const TABLE_STUDENT_IN_CLASS = "student_in_class";
const TABLE_TASK = "task";
const TABLE_STUDENT_TASK = "student_task";
const TABLE_MESSAGE = "message";

///// all web pages ////////

const DEFAULT_WEB_PAGE_KEY = "home";

const WEB_PAGES = array(

    "home" => array(
        "title" => "Main page",
        "controller_class_name" => IntroductionController::class,
        "view_class_name" => View::class,
        "template_type" => "login.twig",
    ),
    "login" => array(
        "title" => "Login",
        "controller_class_name" => AuthPageController::class,
        "view_class_name" => View::class,
        "template_type" => "login.twig",
    ),
    "registration" => array(
        "title" => "Registration",
        "controller_class_name" => AuthPageController::class,
        "view_class_name" => View::class,
        "template_type" => "registration.twig",
    ),
    "all-tasks" => array(
        "title" => "All Tasks",
        "controller_class_name" => AllTasksController::class,
        "view_class_name" => View::class,
        "template_type" => "",
    ),
);