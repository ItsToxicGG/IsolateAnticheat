<?php

namespace Toxic\checks\movement\speed;
use pocketmine\entity\effect\VanillaEffects;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\item\VanillaItems;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\world\Position;
use Toxic\checks\Check;
use Toxic\Session;
use Toxic\utils\Blocks;
use Toxic\utils\Maths;

class SpeedA extends Check {
    public function getId(): int{
        return 0;
    }

    public function getName(): string{
        return "Speed";
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

    public function onMove(PlayerMoveEvent $event): void {
        $player = $event->getPlayer();
        $session = Session::get($player);
        if ($session == null) return;
    
        $currentPos = $event->getFrom();
        $previousPos = $event->getTo();
    
        $distanceX = $currentPos->getX() - $previousPos->getX();
        $distanceY = $currentPos->getY() - $previousPos->getY();
        $distanceZ = $currentPos->getZ() - $previousPos->getZ();
    
        $distance = sqrt($distanceX * $distanceX + $distanceY * $distanceY + $distanceZ * $distanceZ);
    
        $speed = $distance / 0.1;
        
        // player is falling
        if ($previousPos->y < $currentPos->y) return; 
        if ($session->getTeleportTicks() < 40) return;
        if ($session->getMotionTicks() < 40) return;
        if ($session->getAttackTicks() < 40) return;
        if ($session->getFlightTicks() < 40) return;
        if ($session->getGlideTicks() < 40) return;
        $isOnStairs = Blocks::isOnStairs($event->getTo(), 0) || Blocks::isOnStairs($event->getTo(), 1);

        // For now soon ill get maxSpeed when player is on stairs ;D
        if ($isOnStairs) return;

        if ($player->isSprinting() && $session->isJumping()){
            $maxSpeed = 13.1;
        }

        if (!$player->isSprinting() && !$session->isJumping()){
            $maxSpeed = 8.4;
        }

        if (!$player->isSprinting() && $session->isJumping()){
            $maxSpeed = 8.0;
        }

        if ($player->isSprinting() && !$session->isJumping()){
            $maxSpeed = 11.1; 
        }

        if ($speed > $maxSpeed){
            $this->flag($player, "Movement");
        }
    }
}