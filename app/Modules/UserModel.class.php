<?php

namespace zswi\Modules;

class UserModel implements \JsonSerializable
{
    private int $id;

    private string $name;

    private string $login;

    private string $password;

    private string $email;

    /**
     * @param int $id
     * @param string $name
     * @param string $login
     * @param string $password
     * @param string $email
     */
    public function __construct(int $id, string $name, string $login, string $password, string $email)
    {
        $this->id = $id;
        $this->name = $name;
        $this->login = $login;
        $this->password = $password;
        $this->email = $email;
    }

    public static function getUserByLogin(string $login): ?UserModel {
        $db = new MyDatabase();

        $data = $db->getUserDataByLogin($login);

        if (empty($data))
            return null;

        $id = $data["id_user"];
        $login = $data["login"];
        $name = $data["name"];
        $email = $data["email"];
        $password = $data["password"];

        return new UserModel($id, $name, $login, $password, $email);
    }

    public static function getUserByEmail(string $email): ?UserModel {
        $db = new MyDatabase();

        $data = $db->getUserDataByEmail($email);

        if (empty($data))
            return null;

        $id = $data["id_user"];
        $login = $data["login"];
        $name = $data["name"];
        $email = $data["email"];
        $password = $data["password"];

        return new UserModel($id, $name, $login, $password, $email);
    }

    public static function registerNewUser(string $email, string $login, string $password, string $name) : bool {
        $db = new MyDatabase();

        return $db->addUserToDatabase($email, $login, $password, $name);
    }


    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }


    public function jsonSerialize(): array
    {
        return [
            "id" => $this->id,
            "login" => $this->login,
            "email" => $this->email,
            "password" => $this->password,
            "name" => $this->name
        ];
    }
}