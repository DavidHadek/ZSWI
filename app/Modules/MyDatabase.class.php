<?php

namespace zswi\Modules;

use PDOException;
use PDOStatement;

class MyDatabase {

    private \PDO $pdo;

    /**
     * MyDatabase constructor.
     * Inicializace pripojeni k databazi a pokud ma byt spravovano prihlaseni uzivatele,
     * tak i vlastni objekt pro spravu session.
     */
    public function __construct()
    {
        $this->pdo = new \PDO("mysql:host=".DB_SERVER.";dbname=".DB_NAME, DB_USER, DB_PASS);
        $this->pdo->exec("set names utf8");
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }


    ///////////////////  Obecne funkce  ////////////////////////////////////////////

    /**
     * Provede SELECT dotaz na zadané tabulce s volitelnými podmínkami a řazením.
     *
     * @param string $tableName Název tabulky, ze které se má vybírat.
     * @param array $params Asociační pole parametrů pro dotaz.
     * @param string $whereStatement Volitelná WHERE podmínka pro dotaz.
     * @param string $orderByStatement Volitelná ORDER BY podmínka pro dotaz.
     *
     * @return array Vrací pole obsahující všechny řádky získané z databáze na základě provedeného dotazu.
     *               Pokud dotaz narazí na chybu, je vráceno prázdné pole.
     *
     * @throws PDOException Pokud dojde k chybě během provádění dotazu.
     */
    public function selectFromTable(string $tableName, array $params, string $whereStatement = "", string $orderByStatement = ""):array
    {
        $paramsChecked = [];
        foreach ($params as $key => $value) {
            $param = htmlspecialchars($value);
            $paramsChecked[$key] = $param;
        }

        $q = "SELECT * FROM ".$tableName
            .(($whereStatement == "") ? "" : " WHERE $whereStatement")
            .(($orderByStatement == "") ? "" : " ORDER BY $orderByStatement");

        $output = $this->pdo->prepare($q);

        if ($output->execute($paramsChecked)) {
            return $output->fetchAll();
        } else {
            return [];
        }
    }

    /**
     * Vkládá nový záznam do zadané tabulky s určenými sloupci a hodnotami.
     *
     * @param string $tableName Název tabulky, do které se má vkládat záznam.
     * @param string $insertStatement Řetězec obsahující názvy sloupců pro vkládání oddělené čárkami.
     * @param string $insertValues Řetězec obsahující hodnoty pro vkládání oddělené čárkami.
     * @param array $params Asociační pole parametrů pro dotaz.
     *
     * @return bool Vrací true, pokud vkládání proběhlo úspěšně, jinak false.
     *
     * @throws PDOException Pokud dojde k chybě během provádění dotazu.
     */
    public function insertIntoTable(string $tableName, string $insertStatement, string $insertValues, array $params):bool
    {
        $paramsChecked = [];
        foreach ($params as $key => $value) {
            $param = htmlspecialchars($value);
            $paramsChecked[$key] = $param;
        }

        $q = "INSERT INTO $tableName($insertStatement) VALUES ($insertValues)";

        $output = $this->pdo->prepare($q);

        return $output->execute($paramsChecked);
    }

    /**
     * Aktualizuje záznamy v zadané tabulce na základě podmínky.
     *
     * @param string $tableName Název tabulky, ve které se má provést aktualizace.
     * @param string $updateStatementWithValues Řetězec obsahující aktualizační výrazy s hodnotami.
     * @param string $whereStatement Podmínka pro aktualizaci záznamů.
     * @param array $params Asociační pole parametrů pro dotaz.
     *
     * @return bool Vrací true, pokud aktualizace proběhla úspěšně, jinak false.
     *
     * @throws PDOException Pokud dojde k chybě během provádění dotazu.
     */
    public function updateInTable(string $tableName, string $updateStatementWithValues, string $whereStatement, array $params):bool
    {
        $paramsChecked = [];
        foreach ($params as $key => $value) {
            $param = htmlspecialchars($value);
            $paramsChecked[$key] = $param;
        }

        $q = "UPDATE $tableName SET $updateStatementWithValues WHERE $whereStatement";

        $output = $this->pdo->prepare($q);

        return $output->execute($paramsChecked);
    }

    /**
     * Odstraňuje záznamy z dané tabulky na základě podmínky.
     *
     * @param string $tableName Název tabulky, ze které se mají odstranit záznamy.
     * @param string $whereStatement Podmínka pro odstranění záznamů.
     * @param array $params Asociační pole parametrů pro dotaz.
     *
     * @return bool Vrací true, pokud odstranění proběhlo úspěšně, jinak false.
     *
     * @throws PDOException Pokud dojde k chybě během provádění dotazu.
     */
    public function deleteFromTable(string $tableName, string $whereStatement, array $params):bool
    {
        $paramsChecked = [];
        foreach ($params as $key => $value) {
            $param = htmlspecialchars($value);
            $paramsChecked[$key] = $param;
        }

        $q = "DELETE FROM $tableName WHERE $whereStatement";

        $output = $this->pdo->prepare($q);

        return $output->execute($paramsChecked);
    }

    public function addUserToDatabase(string $email, string $login, string $password, string $name) :bool{
        $params = array(
            "kLogin" => $login,
            "kName" => $name,
            "kEmail" => $email,
            "kPassword" => $password,
        );

        $insertStatement = "login, name, password, email";
        $insertValues = ":kLogin, :kName, :kPassword, :kEmail";
        return $this->insertIntoTable(TABLE_USER, $insertStatement, $insertValues, $params);
    }

    public function getUserDataByLogin(string $login) {
        $params = array("kLogin" => $login);
        $user = $this->selectFromTable(TABLE_USER, $params, "login = :kLogin");
        return $user[0];
    }

    public function getUserDataByEmail(string $email) {
        $params = array("kEmail" => $email);
        $user = $this->selectFromTable(TABLE_USER, $params, "email = :kEmail");
        return $user[0];
    }

    public function addClassToDatabase(string $name, string $color, int $id_teacher) :bool{
        $params = array(
            "kName" => $name,
            "kColor" => $color,
            "kIdTeacher" => $id_teacher,
        );

        $insertStatement = "name, color, id_teacher";
        $insertValues = ":kName, :kColor, :kIdTeacher";
        return $this->insertIntoTable(TABLE_CLASS, $insertStatement, $insertValues, $params);
    }

    public function getClassDataByName(string $name) {
        $params = array("kName" => $name);
        $class = $this->selectFromTable(TABLE_CLASS, $params, "name = :kName");
        return $class[0];
    }

    public function getClassesByTeacherID(int $id) :array {
        $params = array("kId" => $id);
        return $this->selectFromTable(TABLE_CLASS, $params, "id_teacher = :kId");
    }

    public function getClassesByStudentID(int $id) :array {
        $params = array("kId" => $id);
        return $this->selectFromTable(TABLE_STUDENT_IN_CLASS, $params, "id_student = :kId");
    }

    public function addTaskToDatabase(string $name, string $instructions, string $date, string $deadline, int $evaluation, int $id_class) :bool{
        $params = array(
            "kName" => $name,
            "kInstructions" => $instructions,
            "kDate" => $date,
            "kDeadline" => $deadline,
            "kEvaluation" => $evaluation,
            "kIdClass" => $id_class,
        );

        $insertStatement = "name, instructions, date, deadline, evaluation, id_class";
        $insertValues = ":kName, :kInstructions, :kDate, :kDeadline, :kEvaluation, :kIdClass";
        return $this->insertIntoTable(TABLE_TASK, $insertStatement, $insertValues, $params);
    }

    public function getAllStudentTasks(int $idStudent) :array {
        $params = array(
            "kIdStudent" => $idStudent,
        );
        return $this->selectFromTable(TABLE_STUDENT_TASK, $params, "id_student = :kIdStudent");
    }

    public function getTaskById(int $idTask) :array {
        $params = array(
            "kIdTask" => $idTask,
        );
        return $this->selectFromTable(TABLE_TASK, $params, "id_task = :kIdTask");
    }

    public function getAllTasksFromClass(int $idClass) :array {
        $params = array(
            "kIdClass" => $idClass,
        );
        return $this->selectFromTable(TABLE_TASK, $params, "id_class = :kIdClass");
    }
}

