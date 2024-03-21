<?php

namespace zswi\Controllers;

use zswi\Modules\MyLogger;
use zswi\Modules\UserModel;


//Might be used for later
//define("smallPassword", 1);
//define("numbersRequired", 2);
//define("capitalRequired", 3);
//define("passwordOk", 0);

class AuthPageController implements IController
{
    private MyLogger $myLG;

    public function __construct() {
        $this->myLG = new MyLogger();
    }

    public function show(string $pageTitle): array
    {
        $templateData = array();

        $templateData["page-title"] = $pageTitle;

        if (isset($_GET["logout"])) {
            $this->logout();
            $templateData["alert-msg"] = "Successfully logout";
        }

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
                $errorMsg = \Alert::SUCCESS->value;
            } else {
                $errorMsg = \Alert::INVALID_USER_PASSWORD->value;
            }
            $templateData["alert-msg"] = $errorMsg;
        }

        return $templateData;
    }


    private function validateAndLogon() : bool {
        $usernameOrEmail = $_POST["username"];
        $password = $_POST["password"];

        $logger = new MyLogger();
        return $logger->userLogin($usernameOrEmail, $password);
    }

    private function validateAndRegister() :string {
        try {
            $email = $_POST["email"];
            $login = $_POST["username"];

            if (empty($email) or empty($login)) {
                return \Alert::NO_EMAIL_LOGIN->value;
            }

            if (UserModel::getUserByEmail($email) != null) {
                return \Alert::EMAIL_ALREADY_EXISTS->value;
            }

            if (UserModel::getUserByLogin($login)) {
                return \Alert::USERNAME_ALREADY_EXISTS->value;
            }

            $password = $_POST["password"];
            $passwordCheck = $_POST["password-check"];
            if ($password != $passwordCheck) {
                return \Alert::PASSWORD_NOT_THE_SAME->value;
            }

            if (!$this->IsPasswordValid($password))
                return \Alert::PASSWORD_NOT_VALID->value;

            $password = password_hash($password, PASSWORD_BCRYPT);
            $name = $_POST["name"] ?? "";

            if (UserModel::registerNewUser($email, $login, $password, $name))
                return \Alert::SUCCESS->value;
            else
                return \Alert::UNKNOWN_ERROR->value;


        } catch (\Exception) {
            return \Alert::UNKNOWN_ERROR->value;
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

    private function logout(): void
    {
        $logger = new MyLogger();
        if ($logger->isUserLogged()) {
            $logger->userLogout();
        }
    }



}