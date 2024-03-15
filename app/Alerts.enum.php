<?php
enum Alert: string
{
    case SUCCESS = 'Success';
    case EMAIL_ALREADY_EXISTS = 'Email already exists';
    case USERNAME_ALREADY_EXISTS = 'Username already exists';
    case PASSWORD_NOT_THE_SAME = 'Passwords are not the same';
    case PASSWORD_NOT_VALID = 'Password is not valid';
    case INVALID_USER_PASSWORD = 'Username or password are invalid';
    case FAILURE = 'Failure';
    case UNKNOWN_ERROR = 'Unknown error';
    case NO_EMAIL_LOGIN = "NO EMAIL OR USERNAME SPECIFIED";
}