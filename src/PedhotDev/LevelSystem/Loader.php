<?php

namespace PedhotDev\LevelSystem;

use PedhotDev\LevelSystem\utils\SingletonTrait;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\Config;

class Loader extends PluginBase {
    use SingletonTrait;

    public Config|null $data = null;
    private Level $levelManager;

    protected function onLoad(): void {
        $this->init();
    }

    protected function onEnable(): void {
        $this->saveDefaultConfig();
        $this->data = new Config($this->getDataFolder() . "data.yml");
        $this->levelManager = new Level();
        $this->levelManager->levels = $this->data->getAll();
        Server::getInstance()->getPluginManager()->registerEvents(new EventListener(), $this);
    }

    protected function onDisable(): void {
        $this->data->setAll($this->levelManager->levels);
    }

    public function getLevelManager(): Level {
        return $this->levelManager;
    }

}