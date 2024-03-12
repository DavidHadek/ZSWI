<?php

namespace zswi\Controllers;

use http\Client\Curl\User;
use zswi\Modules\UserModel;

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

    private function isValidRegistration() :string {
        try {
            $email = $_POST["register"]["email"];
            $login = $_POST["register"]["username"];

            if (UserModel::getUserByEmail($email) != null) {
                return \Alert::EMAIL_ALREADY_EXISTS->value;
            }

            if (UserModel::getUserByLogin($login)) {
                return \Alert::USERNAME_ALREADY_EXISTS->value;
            }

            $password = $_POST["register"]["password"];
            $passwordCheck = $_POST["register"]["password-check"];
            if ($password != $passwordCheck) {
                return \Alert::PASSWORD_NOT_THE_SAME->value;
            }
            //TODO: check the strenght of password

            $password = password_hash($password, PASSWORD_BCRYPT);
            $name = $_POST["register"]["name"] ?? "";

            if (UserModel::registerNewUser($email, $login, $password, $name))
                return \Alert::SUCCESS->value;
            else
                return \Alert::UNKNOWN_ERROR->value;

        } catch (\Exception) {
            return \Alert::UNKNOWN_ERROR->value;
        }
    }

    private function isValidLogin() {

    }



}