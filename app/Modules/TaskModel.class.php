<?php

namespace zswi\Modules;

use zswi\Modules\MyDatabase;

class TaskModel
{
private int $id;
private string $name;
private string $instructions;
private string $date;
private string $deadline;
private int $evaluation;
private int $id_class;

    public function __construct(int $id, string $name, string $instructions, string $date, string $deadline, int $evaluation, int $id_class)
    {
        $this->id = $id;
        $this->name = $name;
        $this->instructions = $instructions;
        $this->date = $date;
        $this->deadline = $deadline;
        $this->evaluation = $evaluation;
        $this->id_class = $id_class;
    }

    public static function createNewTask(string $name, string $instructions, string $date, string $deadline, $evaluation, int $id_class): bool
    {
        $db = new MyDatabase();

        return $db->addTaskToDatabase($name, $instructions, $date, $deadline, $evaluation, $id_class);
    }

    public static function getAllTeacherTasks($idTeacher): array
    {
        $db = new MyDatabase();
        $tasks = array();

        $classes = ClassModel::getClassesByTeacherID($idTeacher);

        foreach ($classes as $class) {
            $temp = $db->getAllTasksFromClass($class->getId());
            foreach ($temp as $tempTask) {
                $tasks[] = new TaskModel($tempTask["id_task"], $tempTask["name"], $tempTask["instructions"],
                    $tempTask["date"], $tempTask["deadline"], $tempTask["evaluation"], $tempTask["id_class"]);
            }
        }

        return $tasks;
    }

    public static function getAllStudentTasks($IdStudent): array
    {
        $db = new MyDatabase();
        $tasks[] = array();

        foreach ($db->getAllStudentTasks($IdStudent) as $stask) {
            $task = $db->getTaskById($stask["id_task"]);
            $tasks[] = new TaskModel($task["id_task"], $task["name"], $task["instructions"],
                $task["date"], $task["deadline"], $task["evaluation"], $task["id_class"]);
        }


        return $tasks;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getInstructions(): string
    {
        return $this->instructions;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getDeadline(): string
    {
        return $this->deadline;
    }

    public function getIdClass(): int
    {
        return $this->id_class;
    }

    public function getEvaluation(): int
    {
        return $this->evaluation;
    }
}

