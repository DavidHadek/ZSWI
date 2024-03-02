<?php

namespace zswi\Models;

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

    ///////////////////  KONEC: Obecne funkce  ////////////////////////////////////////////

    ///////////////////  Konkretni funkce  ////////////////////////////////////////////

    ///////////////////  KONEC: Konkretni funkce  ////////////////////////////////////////////
}

