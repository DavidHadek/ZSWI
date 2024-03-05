<?php

namespace kivweb\Views;

/**
 * Rozhraní pro všechny pohledy (views).
 */
interface IView {

    /**
     * @param array $templateData
     * @param string $pageType
     * @return string
     */
    public function printOutput( array $templateData, string $pageType): string;

}
