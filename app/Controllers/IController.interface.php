<?php

namespace kivweb\Controllers;

/**
 * Rozhraní pro všechny ovladače (kontroléry).
 */
interface IController {

    /**
     * Zajišťuje vypsání příslušné stránky.
     *
     * @param string $pageTitle     Název stránky.
     * @return array                HTML příslušné stránky.
     */
    public function show(string $pageTitle): array;

}
