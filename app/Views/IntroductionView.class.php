<?php

namespace zswi\Views;
class IntroductionView implements IView
{

    public function printOutput(array $templateData, string $pageType): string
    {
        echo "<head>";
        echo "<title> Inroduction page </title>";
        echo "<link href='../../vendor/twbs/bootstrap/dist/css/bootstrap.min.css' rel='stylesheet'>";
        echo "</head>";
        echo $templateData["page-title"] . "<br>";
        echo $templateData["test"] . "<br>";
        echo $templateData["malicious-text"];

        echo "<p class='fw-bolder text-success'>Is bootstrap working for you? This text should be bolder and green.</p>";
        return "";
    }
}