<?php

namespace Toxic\checks\movement\fly;

use pocketmine\entity\effect\VanillaEffects;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use Toxic\checks\Check;
use Toxic\Session;
use Toxic\utils\Blocks;

class FlyA extends Check {

    public function getId(): int{
        return 0;
    }

    public function getName(): string{
        return "Fly";
    }

    public function getMaxViolations(): int{
        return 5;
    }

    public function getSubtype(): string{
        return "A";
    }

    public function getType(): string{
        return "Movement";
    }

    public function kick(): bool{
        return true;
    }

    public function onMove(PlayerMoveEvent $event){
        $player = $event->getPlayer();
        $session = Session::get($player);
        if ($session == null) return;
        $to = $event->getTo();
        $from = $event->getFrom();
    
        // False kick prevention
        if ($player->getEffects()->has(VanillaEffects::JUMP_BOOST()) || $to->y < $from->y) {
            return;
        }
    
        $deltaX = $to->x - $from->x;
        $deltaY = $to->y - $from->y;
        $deltaZ = $to->z - $from->z;
    
        $playerVelocity = new Vector3($deltaX, $deltaY, $deltaZ);
    
        $airAround = Blocks::isInAir($player);
        $fallDistance = $player->getFallDistance();
    
        if ($airAround && (!$player->isOnGround() || abs($playerVelocity->y) > 3) && $player->getInAirTicks() > 25) {
            $maxVerticalVelocity = $session->isJumping() ? 0.8 : 0.62;
    
            if (!$player->isGliding()) {
                $prediction = (
                    ($playerVelocity->y > $maxVerticalVelocity && $airAround && $playerVelocity->y !== 1 && ($session->getPlacingTicks() < 40 && $playerVelocity->y > 5) && ($session->getAttackTicks() < 40 && $playerVelocity->y > 10)) ||
                    ($playerVelocity->y < -4.92 - $fallDistance && $airAround && $playerVelocity->y !== -1 && $playerVelocity->y > -9)                    
                );
    
                if ($prediction) {
                    $this->flag($player, "Movement");
                }
            }
        }
    }
}