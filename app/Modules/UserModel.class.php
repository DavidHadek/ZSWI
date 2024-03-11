<?php

namespace zswi\Modules;

class UserModel implements \JsonSerializable
{
    private int $id;

    private string $name;

    private string $login;

    private string $password;

    private string $email;

    private int $idRights;

    /**
     * @param int $id
     * @param string $name
     * @param string $login
     * @param string $password
     * @param string $email
     * @param int $idRights
     */
    public function __construct(int $id, string $name, string $login, string $password, string $email, int $idRights)
    {
        $this->id = $id;
        $this->name = $name;
        $this->login = $login;
        $this->password = $password;
        $this->email = $email;
        $this->idRights = $idRights;
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
        $idRights = $data["id_right"];

        return new UserModel($id, $name, $login, $password, $email, $idRights);
    }

    public static function getUserByEmail(string $email): ?UserModel {
        $db = new MyDatabase();

        $data = $db->getUserDataByLogin($email);

        if (empty($data))
            return null;

        $id = $data["id_user"];
        $login = $data["login"];
        $name = $data["name"];
        $email = $data["email"];
        $password = $data["password"];
        $idRights = $data["id_right"];

        return new UserModel($id, $name, $login, $password, $email, $idRights);
    }

    public static function registerNewUser(string $email, string $login, string $password, string $name) {
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

    public function getIdRights(): int
    {
        return $this->idRights;
    }


    public function jsonSerialize(): array
    {
        return [
            "id" => $this->id,
            "login" => $this->login,
            "email" => $this->email,
            "password" => $this->password,
            "name" => $this->name,
            "id_rights" => $this->idRights,
        ];
    }
}