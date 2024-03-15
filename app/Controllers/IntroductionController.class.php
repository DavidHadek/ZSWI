<?php

namespace zswi\Controllers;

use zswi\Models\ClassModel;
use zswi\Models\MyLogger;

class IntroductionController implements IController
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

            $classroomData = $this->getClassrooms($userData->getId());
            foreach ($classroomData as $class) {
                $tplData["classes"][] = [$class->getName(), $class->getColor()];
            }
        }

        return $tplData;
    }

    private function getClassrooms(int $id) : array {
        $teacher = ClassModel::getClassesByTeacherID($id);
        $student = ClassModel::getClassesByStudentID($id);

        return array_merge($teacher, $student);
    }
}