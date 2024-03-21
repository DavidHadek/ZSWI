<?php

namespace zswi\Controllers;

use zswi\Models\ClassModel;
use zswi\Models\MyLogger;
use zswi\Modules\MyDatabase;
use zswi\Modules\TaskModel;


class AllTasksController implements IController
{
    private MyLogger $myLG;

    public function __construct() {
        $this->myLG = new MyLogger();
    }

    public function show(string $pageTitle): array
    {
        $tplData = array();

        $tplData["page-title"] = $pageTitle;

        if ($this->myLG->isUserLogged()) {
            $userData = $this->myLG->getLoggedUserData();
            $tplData["name"] = $userData->getName();
            //TODO IMAGE

            $tasks = $this->getAllTasks($userData->getId());

            foreach ($tasks as $task) {
                $tplData["tasks"][] = [$task->getName(), $task->getDeadline(), $task->isDone(), $task->getInstructions()];
            }
            //TODO CLASS COLOR

        }   else {
            header("Location: index.php?page=auth");
            exit();
        }

        return $tplData;
    }

    private function getAllTasks($id): array
    {
        return array_merge($this->getAllStudentTasks($id), $this->getAllTeacherTasks($id));
    }

    private function getAllStudentTasks($IdStudent): array
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

    private function getAllTeacherTasks($idTeacher): array
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
}
