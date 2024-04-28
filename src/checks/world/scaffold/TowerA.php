<?php

namespace Toxic\checks\world\scaffold;

use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\player\PlayerMoveEvent;
use Toxic\checks\Check;
use Toxic\Session;
use Toxic\utils\Blocks;
use Toxic\utils\Maths;

class TowerA extends Check {
    public function getId(): int{
        return 6;
    }

    public function getName(): string{
        return "Tower";
    }

    public function getMaxViolations(): int{
        return 5;
    }

    public function getSubtype(): string{
        return "A";
    }

    public function getType(): string{
        return "Placement";
    }

    public function kick(): bool{
        return true;
    }

    public function onPlace(BlockPlaceEvent $event): void {
        $player = $event->getPlayer();
        $session = Session::get($player);
        if ($session === null) return;
        $block = $event->getBlockAgainst();
        $playerLocation = $player->getLocation();
        $blockUnder = $player->getWorld()->getBlockAt((int)$playerLocation->getX(), (int)($playerLocation->getY() - 1), (int)$playerLocation->getZ()) ?? Blocks::getBlockBelow($player);
        
        if ($playerLocation->getPitch() === 90 && $blockUnder->getPosition()->getX() === $block->getPosition()->getX() && $blockUnder->getPosition()->getZ() === $block->getPosition()->getZ()) {
            $this->flag($player, "Placement");
        }
    }
}