<?php

namespace zswi\Views;
class IntroductionView implements IView
{

    public function printOutput(array $templateData, string $pageType): string
    {
//        echo "<link rel='stylesheet' href='$pathCss'>";
//        echo "<script type='text/javascript' src='$pathJs'></script";
        echo $templateData["page-title"] . "<br>";
        echo $templateData["test"] . "<br>";
        echo $templateData["malicious-text"];

        echo "<p class='fw-bolder text-success'>Is bootstrap working for you? This text should be bolder and green.</p>";
        return "";
    }
}