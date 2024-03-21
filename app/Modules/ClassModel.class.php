<?php

namespace zswi\Modules;

class ClassModel
{
    private int $id;
    private string $name;
    private string $color;
    private int $id_teacher;

    /**
     * @param int $id
     * @param string $name
     * @param string $color
     * @param int $id_teacher
     */
    public function __construct(int $id, string $name, string $color, int $id_teacher)
    {
        $this->id = $id;
        $this->name = $name;
        $this->color = $color;
        $this->id_teacher = $id_teacher;
    }

    public static function getClassByName(string $name): ?ClassModel {
        $db = new MyDatabase();

        $data = $db->getClassDataByName($name);

        if (empty($data)) {
            return null;
        }

        $id = $data["id_class"];
        $name = $data["name"];
        $color = $data["color"];
        $id_teacher = $data["id_teacher"];

        return new ClassModel($id, $name, $color, $id_teacher);
    }

    public static function getClassesByTeacherID(int $id): array {
        $db = new MyDatabase();

        $classes = array();
        $count = 0;
        $data = $db->getClassesByTeacherID($id);

        if (empty($data)) {
            return [];
        }

        foreach ($data as $class) {
            $classes[$count] = new ClassModel($class["id_class"], $class["name"], $class["color"], $class["id_teacher"]);
            $count++;
        }

        return $classes;
    }

    public static function getClassesByStudentID(int $id): array
    {
        $db = new MyDatabase();

        $classes = array();
        $count = 0;
        $data = $db->getClassesByStudentID($id);

        if (empty($data)) {
            return [];
        }

        foreach ($data as $class) {
            $classes[$count] = new ClassModel($class["id_class"], $class["name"], $class["color"], $class["id_teacher"]);
            $count++;
        }

        return $classes;
    }

    public static function createNewClass(string $name, string $color, int $id_teacher) : bool {
        $db = new MyDatabase();

        return $db->addClassToDatabase($name, $color, $id_teacher);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function getIDTeacher(): int
    {
        return $this->id_teacher;
    }




}