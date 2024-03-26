<?php

namespace zswi\Controllers;

use zswi\Modules\ClassModel;
use zswi\Modules\MyLogger;

class IntroductionController implements IController
{
    private MyLogger $myLG;

    public function __construct() {
        $this->myLG = new MyLogger();
    }

    public function show(string $pageTitle): array
    {
        $tplData = HeaderController::getHeaderTemplateData();

        $tplData["page-title"] = $pageTitle;

        if ($this->myLG->isUserLogged()) {
            $userData = $this->myLG->getLoggedUserData();
            $tplData["name"] = $userData->getName();
            //TODO IMAGE

            $classroomData = $this->getClassrooms($userData->getId());
            foreach ($classroomData as $class) {
                $tplData["classes"][] = ["name" => $class->getName(), "color" => $class->getColor()];
            }
        }   else {
            header("Location: index.php?page=login");
        }

        return $tplData;
    }

    private function getClassrooms(int $id) : array {
        $teacher = ClassModel::getClassesByTeacherID($id);
        $student = ClassModel::getClassesByStudentID($id);

        return array_merge($teacher, $student);
    }
}