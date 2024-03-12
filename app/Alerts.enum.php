<?php
enum Alert: string
{
    case SUCCESS = 'Success';
    case EMAIL_ALREADY_EXISTS = 'Email already exists';
    case USERNAME_ALREADY_EXISTS = 'Username already exists';
    case PASSWORD_NOT_THE_SAME = 'Passwords are not the same';
    case FAILURE = 'Failure';
    case UNKNOWN_ERROR = 'Unknown error';
}