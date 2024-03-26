<?php

namespace zswi\Controllers;

use zswi\Modules\MySession;

class HeaderController implements IController
{

    public static function getHeaderTemplateData() : array {
        $headerController = new HeaderController();
        return $headerController->show("");
    }

    public function show(string $pageTitle): array
    {
        $session = new MySession();

        $templateData = array();

        $templateData["alerts"] = $session->getAlerts();
        $session->removeAlerts();

        if ($session->isSessionSet("user")) {
            $templateData["user"] = $session->readSession("user");
            $templateData["logon"] = true;
        } else {
            $templateData["logon"] = false;
        }

        return $templateData;
    }
}