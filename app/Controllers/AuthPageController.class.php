<?php

namespace zswi\Controllers;

use zswi\Alerts;
use zswi\Modules\MyLogger;
use zswi\Modules\MySession;
use zswi\Modules\UserModel;


//Might be used for later
//define("smallPassword", 1);
//define("numbersRequired", 2);
//define("capitalRequired", 3);
//define("passwordOk", 0);

class AuthPageController implements IController
{
    private MyLogger $myLG;
    private MySession $mySession;

    public function __construct() {
        $this->myLG = new MyLogger();
        $this->mySession = new MySession();
    }

    public function show(string $pageTitle): array
    {
        $templateData = HeaderController::getHeaderTemplateData();

        $templateData["page-title"] = $pageTitle;

        if (isset($_POST["logout"])) {
            $this->logout();
            $this->mySession->addAlert(Alerts::SUCCESS);
            header("Location: index.php");
        }

//        if (isset($_GET["part"]) && $_GET["part"] == "register") {
//            $templateData["part"] = "register";
//        } else {
//            $templateData["part"] = "login";
//        }

        if (isset($_POST["register"])) {
            $alert = $this->validateAndRegister();
            $this->mySession->addAlert($alert);
            if ($alert == Alerts::SUCCESS) {
                header("Location: index.php?page=login");
            }
        }

        if (isset($_POST["login"])) {
            if ($this->validateAndLogon()) {
                $alert = Alerts::SUCCESS;
                $this->mySession->addAlert($alert);
                header("Location: index.php?page=home");
            } else {
                $alert = Alerts::INVALID_USER_PASSWORD;
                $this->mySession->addAlert($alert);
                header("Location: index.php?page=login");
            }

        }

        return $templateData;
    }


    private function validateAndLogon() : bool {
        $usernameOrEmail = $_POST["username"];
        $password = $_POST["password"];

        $logger = new MyLogger();
        return $logger->userLogin($usernameOrEmail, $password);
    }

    private function validateAndRegister() :Alerts {
        try {
            $email = $_POST["email"];
            $login = $_POST["username"];

            if (empty($email) or empty($login)) {
                return Alerts::NO_EMAIL_LOGIN;
            }

            if (UserModel::getUserByEmail($email) != null) {
                return Alerts::EMAIL_ALREADY_EXISTS;
            }

            if (UserModel::getUserByLogin($login)) {
                return Alerts::USERNAME_ALREADY_EXISTS;
            }

            $password = $_POST["password"];
            $passwordCheck = $_POST["password2"];
            if ($password != $passwordCheck) {
                return Alerts::PASSWORD_NOT_THE_SAME;
            }

            if (!$this->IsPasswordValid($password))
                return Alerts::PASSWORD_NOT_VALID;

            $password = password_hash($password, PASSWORD_BCRYPT);

            $name = $_POST["name"] ?? "";

            if (isset($_POST["surname"]))
                $name = $name . " " . $_POST["surname"];

            if (UserModel::registerNewUser($email, $login, $password, $name))
                return Alerts::SUCCESS;
            else
                return Alerts::UNKNOWN_ERROR;


        } catch (\Exception) {
            return Alerts::UNKNOWN_ERROR;
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

    private function logout() {
        $logger = new MyLogger();
        if ($logger->isUserLogged()) {
            $logger->userLogout();
        }
    }



}