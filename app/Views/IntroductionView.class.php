<?php

namespace zswi\Views;
class IntroductionView implements IView
{

    public function printOutput(array $templateData, string $pageType)
    {
        require_once ROOT. '/vendor/autoload.php';

        $templatesDirectory = TWIG_TPL_DIR;
//        $webInfo = WEB_PAGES[$pageType];
        $currentTemplateName = $pageType;
        var_dump($templatesDirectory);
        $loader = new \Twig\Loader\FilesystemLoader($templatesDirectory);
        $twig = new \Twig\Environment($loader, ['debug' => true,]);

        $twig->addExtension(new \Twig\Extension\DebugExtension());

        echo $twig->render($currentTemplateName, $templateData);
    }
}