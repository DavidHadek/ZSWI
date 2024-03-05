<?php

namespace zswi\Models;

class MySession {

    /**
     * Constructor for starting session.
     */
    public function __construct()
    {
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

}