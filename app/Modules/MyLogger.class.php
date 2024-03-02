<?php

namespace zswi\Models;

use PDOException;

class MyLogger {

    private MyDatabase $myDB;
    private MySession $mySession;
    private const KEY_USER = "current_user_id";

    public function __construct()
    {
        $this->myDB = new MyDatabase();
        $this->mySession = new MySession();
    }

    /**
     * Function checks if user can be logged, if yes, it loggs him in.
     *
     * @param string $login
     * @param string $password
     *
     * @return bool
     *
     * @throws PDOException
     */
    public function userLogin(string $login, string $password): bool {

        $params = array("kLogin" => $login);
        $where = "login = :kLogin";
        $user = $this->myDB->selectFromTable(TABLE_USER, $params, $where);

        if (!empty($user)) {
            if (password_verify($password, $user[0]['password'])) {
                $this->mySession->addSession(self::KEY_USER, $user[0]['id_user']);
                return true;
            }
        }

        return false;
    }

    /**
     * Loggs out current user.
     *
     * @return void
     */
    public function userLogout(): void
    {
        $this->mySession->removeSession(self::KEY_USER);
    }

    /**
     * Function tests if user is logged.
     *
     * @return bool
     */
    public function isUserLogged():bool {
        return $this->mySession->isSessionSet(self::KEY_USER);
    }

    /**
     * Function returns current user's data if.
     *
     * @return mixed|null
     *
     * @throws PDOException
     */
    public function getLoggedUserData(): mixed
    {
        //TODO
        return null;
    }
}
