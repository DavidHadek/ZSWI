<?php

namespace zswi\Views;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

class View
{
    public function printOutput(array $templateData, string $pageType): void
    {
        require_once ROOT . '/vendor/autoload.php';

        $templatesDirectory = TWIG_TPL_DIR;
//        $webInfo = WEB_PAGES[$pageType];
        $currentTemplateName = $pageType;
        var_dump($pageType);
        $loader = new FilesystemLoader($templatesDirectory);
        $twig = new Environment($loader, ['debug' => true,]);

        $twig->addExtension(new DebugExtension());

        try {
            echo $twig->render($currentTemplateName, $templateData);
        } catch (LoaderError $e) {
            // Handle template loading errors
            echo 'Template loading error: ' . $e->getMessage();
        } catch (RuntimeError $e) {
            // Handle runtime errors (e.g., variable issues)
            echo 'Twig runtime error: ' . $e->getMessage();
        } catch (SyntaxError $e) {
            // Handle syntax errors in your Twig templates
            echo 'Twig syntax error: ' . $e->getMessage();
        }
    }
}