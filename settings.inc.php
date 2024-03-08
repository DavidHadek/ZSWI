<?php

////// connection consts for database ///////

const DB_SERVER = "localhost";
const DB_NAME = "web";
const DB_USER = "root";
const DB_PASS = "";

const TABLE_USER = "user";
const TABLE_RIGHT = "right";
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
        "controller_class_name" => \zswi\Controllers\IntroductionController::class,
        "view_class_name" => \zswi\Views\IntroductionView::class,
        "template_type" => "",
    )
);