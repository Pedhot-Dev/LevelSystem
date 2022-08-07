<?php

namespace PedhotDev\LevelSystem\level;

use PedhotDev\LevelSystem\Loader;

class LevelManager {

    private Level $levelClass;

    public function __construct() {
        $this->levelClass = new Level();
    }

    public function saveAll() {
        $data = Loader::getInstance()->data;
        $data->setAll($this->getLevelClass()->levels);
    }

    public function getLevelClass(): Level {
        return $this->levelClass;
    }

}