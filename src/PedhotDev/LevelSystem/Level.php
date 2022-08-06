<?php

namespace PedhotDev\LevelSystem;

use PedhotDev\LevelSystem\event\LevelUpEvent;
use pocketmine\player\Player;
use pocketmine\Server;

class Level {

    public const DEFAULT_LEVEL = 1;
    public const DEFAULT_EXP = 0;

    public $levels = [];

    public function set(string $type, $player, int $value): bool {
        if (in_array($type, ["level", "exp"])) return false;
        if ($player instanceof Player) {
            $player = $player->getName();
        }
        $player = strtolower($player);
        $this->levels[$type][$player] = $value;
        return true;
    }

    public function get(string $type, $player): int {
        if (in_array($type, ["level", "exp"])) return 0;
        if ($player instanceof Player) {
            $player = $player->getName();
        }
        $player = strtolower($player);
        return $this->levels[$type][$player];
    }

    public function setLevel($player, int $value): bool {
        if ($player instanceof Player) {
            $player = $player->getName();
        }
        $player = strtolower($player);
        $this->set("level", $player, $value);
        return true;
    }

    public function getLevel($player): int {
        if ($player instanceof Player) {
            $player = $player->getName();
        }
        $player = strtolower($player);
        return $this->get("level", $player);
    }

    public function setExp($player, int $value): bool {
        if ($player instanceof Player) {
            $player = $player->getName();
        }
        $player = strtolower($player);
        $this->set("exp", $player, $value);
        return true;
    }

    public function getExp($player): int {
        if ($player instanceof Player) {
            $player = $player->getName();
        }
        $player = strtolower($player);
        return $this->get("exp", $player);
    }

    public function addExp($player): bool {
        if ($player instanceof Player) {
            $player = $player->getName();
        }
        $player = strtolower($player);
        $this->setExp($player, $this->getExp($player) + 1);
        if ($this->getExp($player) >= ($this->getLevel($player * 100))) {
            $this->setExp($player, 0);
            $this->setLevel($player, $this->getLevel($player) + 1);
            (new LevelUpEvent(Server::getInstance()->getPlayerExact($player), $this->getLevel($player)))->call();
        }
        return true;
    }

    public function saveAll() {
        $data = Loader::getInstance()->data;
        $data->setAll($this->levels);
    }

}