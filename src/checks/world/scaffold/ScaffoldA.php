<?php

namespace Toxic\checks\world\scaffold;

use pocketmine\event\block\BlockPlaceEvent;
use Toxic\checks\Check;
use Toxic\Session;
use Toxic\utils\Maths;

class ScaffoldA extends Check {
    public function getId(): int{
        return 6;
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

        $loc = $session->getLocation();
        if (empty($loc)) return;

        $to = $loc['to'];
        $from = $loc['from'];

        $deltaX = $to->getX() - $from->getX();
        $deltaZ = $to->getZ() - $from->getZ();
        
        $velocityMagnitude = sqrt($deltaX ** 2 + $deltaZ ** 2);

        $rotation = $player->getLocation()->getYaw();
        
        $isValidRotation = ($rotation === 60 || $rotation === -85);
    
        $isValidPlacement = !$player->isGliding() &&
          $velocityMagnitude > 0.2 &&
          $block->getPosition()->getY() < $player->getPosition()->getY() &&
          (($rotation % 1 === 0 ||
          ($rotation % 5 === 0 && abs($rotation) !== 90)) &&
          $rotation !== 0 && $rotation !== 90);        

        if (!$isValidPlacement || !$isValidRotation){
            $this->flag($player, "Placement");
        }
    }
}