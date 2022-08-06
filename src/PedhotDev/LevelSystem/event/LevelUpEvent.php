<?php

namespace PedhotDev\LevelSystem\event;

use pocketmine\event\Event;
use pocketmine\player\Player;

class LevelUpEvent extends Event {

    public function __construct(public Player $player, public int $newLevel) {
    }

    /**
     * @return Player
     */
    public function getPlayer(): Player {
        return $this->player;
    }

    /**
     * @return int
     */
    public function getNewLevel(): int {
        return $this->newLevel;
    }

}