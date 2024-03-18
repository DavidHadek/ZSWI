<?php

namespace zswi;

class ApplicationStart {

    public function appStart(): void
    {
        if (!empty($_GET['page']) && array_key_exists($_GET['page'], WEB_PAGES)) {
            $pageSettings = WEB_PAGES[$_GET['page']];
        } else {
            $pageSettings = WEB_PAGES[DEFAULT_WEB_PAGE_KEY];
        }

//        $pageSettings = WEB_PAGES['auth'];
        var_dump($pageSettings);
        $controller = new $pageSettings["controller_class_name"];
        $data = $controller->show($pageSettings["title"]);
        $view = new $pageSettings["view_class_name"];
        $view->printOutput($data, $pageSettings["template_type"]);
    }
}
