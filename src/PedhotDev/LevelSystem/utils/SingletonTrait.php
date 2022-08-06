<?php

namespace PedhotDev\LevelSystem\utils;

trait SingletonTrait {

    private static $instance = null;

    public function init(): void {
        self::$instance = $this;
    }

    public static function getInstance(): self {
        return self::$instance;
    }

}