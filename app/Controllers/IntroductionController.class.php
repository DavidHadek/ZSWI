<?php

namespace zswi\Controllers;

class IntroductionController implements IController
{

    public function show(string $pageTitle): array
    {
        $tplData = array();

        $tplData["page-title"] = $pageTitle;
        $tplData["test"] = "This is a testing page. Seems like it works!";

        $purifier = \HTMLPurifier::getInstance();
        $tplData["malicious-text"] = $purifier->purify("<script src='dkawpodkpoawd'>dawdawd</script> ahoj");


        return $tplData;
    }


}