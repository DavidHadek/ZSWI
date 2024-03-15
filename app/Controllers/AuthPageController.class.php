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
            $errorMsg = $this->isValidRegistration();
        }

        if (isset($_POST["login"])) {
            $this->logonUser();
        }

        return $templateData;
    }


    private function logonUser() {

    }
    private function registerUser() {

    }

    private function isValidRegistration() :string {
        try {
            $email = $_POST["register"]["email"];
            $login = $_POST["register"]["username"];
            if (UserModel::getUserByEmail($email) != null) {
                return "EMAIL ALREADY EXISTS";
            }

            if (UserModel::getUserByLogin($login)) {
                return "USERNAME ALREADY EXISTS";
            }

            $password = $_POST["register"]["password"];
            $passwordCheck = $_POST["register"]["password-check"];
            if ($password != $passwordCheck) {
                return "PASSWORD NOT THE SAME";
            }

            $password = password_hash($password, PASSWORD_BCRYPT);
            $name = $_POST["register"]["name"] ?? "";

            if (!$this->IsPasswordValid($password))
                return "PASSWORD NOT VALID";

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


    private function isValidLogin() {

    }



}