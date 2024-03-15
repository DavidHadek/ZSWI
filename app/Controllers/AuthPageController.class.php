<?php

namespace zswi\Controllers;

use zswi\Modules\UserModel;


//Might be used for later
//define("smallPassword", 1);
//define("numbersRequired", 2);
//define("capitalRequired", 3);
//define("passwordOk", 0);

class AuthPageController implements IController
{

    public function show(string $pageTitle): array
    {
        $templateData = array();

        $templateData["page-title"] = $pageTitle;

        if (isset($_GET["part"]) && $_GET["part"] == "register") {
            $templateData["part"] = "register";
        } else {
            $templateData["part"] = "login";
        }

        if (isset($_POST["register"])) {
            $errorMsg = $this->validateAndRegister();
            $templateData["alert-msg"] = $errorMsg;
        }

        if (isset($_POST["login"])) {
            if ($this->validateAndLogon()) {
                $errorMsg = "SUCCESS";
            } else {
                $errorMsg = "INVALID USERNAME OR PASSWORD";
            }
            $templateData["alert-msg"] = $errorMsg;
        }

        return $templateData;
    }


    private function validateAndLogon() : bool {
        $usernameOrEmail = $_POST["username"];
        $password = $_POST["password"];

        if (empty($usernameOrEmail) or empty($password))
            return false;

        $user = empty($user) ? UserModel::getUserByLogin($usernameOrEmail) : null;
        $user = empty($user) ? UserModel::getUserByEmail($usernameOrEmail) : $user;

        if (empty($user))
            return false;


        if (!password_verify($password, $user->getPassword()))
            return false;


        session_start();

        $_SESSION["user"] = $user;
        return true;
    }

    private function validateAndRegister() :string {
        try {
            $email = $_POST["email"];
            $login = $_POST["username"];

            if (empty($email) or empty($login)) {
                return "NO EMAIL OR USERNAME SPECIFIED";
            }

            if (UserModel::getUserByEmail($email) != null) {
                return "EMAIL ALREADY EXISTS";
            }

            if (UserModel::getUserByLogin($login)) {
                return "USERNAME ALREADY EXISTS";
            }

            $password = $_POST["password"];
            $passwordCheck = $_POST["password-check"];
            if ($password != $passwordCheck) {
                return "PASSWORD NOT THE SAME";
            }

            if (!$this->IsPasswordValid($password))
                return "PASSWORD NOT VALID";

            $password = password_hash($password, PASSWORD_BCRYPT);
            $name = $_POST["name"] ?? "";

            if (UserModel::registerNewUser($email, $login, $password, $name))
                return "SUCCESS";
            else
                return "UNKNOWN ERROR";


        } catch (\Exception) {
            return "UNKNOWN ERROR";
        }
    }


    /**
     * @param string $password
     * Checks if Password is valid for registration
     * 8 letters, contains numbers, contains capital
     * @return bool true if the password is valid, false othewise
     */

    private function isPasswordValid(string $password): bool{
        if (strlen($password) < 8){
            return false;
        } elseif (!preg_match('/\d/', $password)){
            return false;
        } elseif (!preg_match('/[A-Z]/', $password)){
            return false;
        }
        return true;
    }



}