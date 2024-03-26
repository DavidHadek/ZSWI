<?php

namespace zswi\Modules;

use zswi\Alerts;

class MySession {

    /**
     * Constructor for starting session.
     */
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();
    }

    /**
     * Function for putting data into session
     *
     * @param string $key
     * @param mixed $value
     */
    public function addSession(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Checks if session is set.
     *
     * @param string $key
     *
     * @return bool
     */
    public function isSessionSet(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    /**
     * Function returns value of session if it is setted.
     *
     * @param string $key
     *
     * @return mixed|null
     */
    public function readSession(string $key): mixed
    {
        if ($this->isSessionSet($key)) {
            return $_SESSION[$key];
        } else {
            return null;
        }
    }

    /**
     * Function removes session.
     *
     * @param string $key
     */
    public function removeSession(string $key): void
    {
        unset($_SESSION[$key]);
    }

    /**
     * Function to push an alert into the array
     * If the array doesn't exist yet, it will instantiate a new one
     * @param Alerts $alert
     * @return void
     */
    public function addAlert(Alerts $alert) {
        if (empty($_SESSION["alerts"])) {
            $_SESSION["alerts"] = array();
        }
        $_SESSION["alerts"][] = $alert;
    }

    /**
     * Gets all the arrays from the session as an array
     * or null if there are not any.
     * It doesn't delete them.
     * @return array|null
     */
    public function getAlerts() {
        if (empty($_SESSION["alerts"]))
            return null;

        $alerts = array();
        for ($i = 0; $i < sizeof($_SESSION["alerts"]); $i++) {
            $alerts[$i] = $_SESSION["alerts"][$i];
        }
        return $alerts;
    }

    /**
     * Method to remove all the alerts from the array
     * @return void
     */
    public function removeAlerts() {
        $_SESSION["alerts"] = array();
    }

}