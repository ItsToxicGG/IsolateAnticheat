<?php

namespace DAC\checks\world\scaffold;

use pocketmine\event\block\BlockPlaceEvent;
use Toxic\checks\Check;
use Toxic\Session;
use Toxic\utils\Maths;

class ScaffoldA extends Check {
    public function getId(): int{
        return 0;
    }

    public function getName(): string{
        return "Scaffold";
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
    }
}