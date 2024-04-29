<?php

namespace Toxic\checks\world\scaffold;

use pocketmine\block\BlockTypeIds;
use pocketmine\entity\effect\VanillaEffects;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\player\GameMode;
use Toxic\checks\Check;
use Toxic\Session;
use Toxic\utils\Blocks;
use Toxic\utils\Maths;

class TowerB extends Check {
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
        return "B";
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

        $blockUnder = Blocks::getBlockBelow($player);

        if (
            !$player->isFlying() &&
            $session->isJumping() &&
            $player->getMotion()->y < 1 &&
            $player->getFallDistance() < 0 &&
            $block->getPosition()->x === $blockUnder->getPosition()->x &&
            $block->getPosition()->y === $blockUnder->getPosition()->y &&
            $block->getPosition()->z === $blockUnder->getPosition()->z &&
            !$player->getEffects()->has(VanillaEffects::JUMP_BOOST())
        ) {
            $yPosDiff = abs($player->getLocation()->y % 1);
        
            if ($yPosDiff > 0.35 && $player->getGamemode() !== GameMode::CREATIVE() && !$player->getAllowFlight()) {
                $this->flag($player, "Tower", "B");
            }
        }
    }
}