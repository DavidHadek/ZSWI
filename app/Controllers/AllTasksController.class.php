<?php

namespace zswi\Controllers;

use zswi\Modules\ClassModel;
use zswi\Modules\MyLogger;
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
                $class = ClassModel::getClassById($task->getIdClass());
                $tplData["tasks"][] = [
                    "name" => $task->getName(),
                    "deadline" => $task->getDeadline(),
                    "color" => $class["color"],
                    "isDone" => $task->isDone(),
                    "instructions" => $task->getInstructions()];
            }
        }   else {
            header("Location: index.php?page=auth");
            exit();
        }

        return $tplData;
    }

    private function getAllTasks($id): array
    {
        return array_merge(TaskModel::getAllStudentTasks($id), TaskModel::getAllTeacherTasks($id));
    }
}
