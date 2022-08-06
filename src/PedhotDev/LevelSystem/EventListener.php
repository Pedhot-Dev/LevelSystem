<?php

namespace PedhotDev\LevelSystem;

use PedhotDev\LevelSystem\event\LevelUpEvent;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\Server;

class EventListener implements Listener {

    public function onLevelUp(LevelUpEvent $event) {
        $player = $event->getPlayer();
        $newLevel = $event->getNewLevel();
        foreach (Server::getInstance()->getOnlinePlayers() as $onlinePlayer) {
            if ($onlinePlayer->getName() === $player->getName()) {
                $onlinePlayer->sendMessage("§bLEVEL: §fYour level upgraded from §a" . (Loader::getInstance()->getConfig()->getNested("custom-level-name." . ($newLevel - 1)) ?? str_replace(["{level}"], [($newLevel - 1)], Loader::getInstance()->getConfig()->getNested("custom-level-name.default", "Level {level}"))) . " §fto §a" . (Loader::getInstance()->getConfig()->getNested("custom-level-name." . $newLevel) ?? str_replace(["{level}"], [$newLevel], Loader::getInstance()->getConfig()->getNested("custom-level-name.default", "Level {level}"))) . "§f!");
            }else {
                $onlinePlayer->sendMessage("§bLEVEL: §f" . $player->getName() . " level upgraded from §a" . (Loader::getInstance()->getConfig()->getNested("custom-level-name." . ($newLevel - 1)) ?? str_replace(["{level}"], [($newLevel - 1)], Loader::getInstance()->getConfig()->getNested("custom-level-name.default", "Level {level}"))) . " §fto §a" . (Loader::getInstance()->getConfig()->getNested("custom-level-name." . $newLevel) ?? str_replace(["{level}"], [$newLevel], Loader::getInstance()->getConfig()->getNested("custom-level-name.default", "Level {level}"))) . "§f!");
            }
        }
        $player->sendTitle("New Level: §a" . (Loader::getInstance()->getConfig()->getNested("custom-level-name." . $newLevel) ?? str_replace(["{level}"], [$newLevel], Loader::getInstance()->getConfig()->getNested("custom-level-name.default", "Level {level}"))));
    }

    public function onJoin(PlayerJoinEvent $event) {
        $levelManager = Loader::getInstance()->getLevelManager();
        $player = $event->getPlayer();
        if (!isset($levelManager->levels["level"][$player->getName()])) {
            $levelManager->setLevel($player, 1);
        }
        if (!isset($levelManager->levels["exp"][$player->getName()])) {
            $levelManager->setExp($player, 0);
        }
    }

    public function onBreakBlock(BlockBreakEvent $event) {
        $player = $event->getPlayer();
        if ($player->isCreative()) return;
        $levelManager = Loader::getInstance()->getLevelManager();
        $levelManager->addExp($player);
    }

    public function onPlaceBlock(BlockPlaceEvent $event) {
        $player = $event->getPlayer();
        if ($player->isCreative()) return;
        $levelManager = Loader::getInstance()->getLevelManager();
        $levelManager->addExp($player);
    }

}