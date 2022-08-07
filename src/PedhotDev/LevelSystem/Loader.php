<?php

namespace PedhotDev\LevelSystem;

use PedhotDev\LevelSystem\level\LevelManager;
use PedhotDev\LevelSystem\utils\SingletonTrait;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\Config;

class Loader extends PluginBase {
    use SingletonTrait;

    public Config|null $data = null;
    private LevelManager $levelManager;

    protected function onLoad(): void {
        $this->init();
    }

    protected function onEnable(): void {
        $this->saveDefaultConfig();
        $this->data = new Config($this->getDataFolder() . "data.yml");
        $this->levelManager = new LevelManager();
        $this->levelManager->getLevelClass()->levels = $this->data->getAll();
        Server::getInstance()->getPluginManager()->registerEvents(new EventListener(), $this);
    }

    protected function onDisable(): void {
        $this->levelManager->saveAll();
    }

    public function getLevelManager(): LevelManager {
        return $this->levelManager;
    }

}