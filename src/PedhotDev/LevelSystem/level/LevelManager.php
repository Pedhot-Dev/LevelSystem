<?php

namespace PedhotDev\LevelSystem\level;

use PedhotDev\LevelSystem\Loader;

class LevelManager {

    public function saveAll() {
        $data = Loader::getInstance()->data;
        $data->setAll($this->getLevelClass()->levels);
    }

    public function getLevelClass(): Level {
        return new Level();
    }

}