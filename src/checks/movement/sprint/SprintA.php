<?php

namespace Toxic\Checks\movement\sprint;

use pocketmine\block\BlockTypeIds;
use pocketmine\entity\effect\VanillaEffects;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use Toxic\checks\Check;
use Toxic\Session;

class SprintA extends Check {

    public function getId(): int{
        return 4;
    }

    public function getName(): string{
        return "Sprint";
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

    private array $lastPositions = [];

    public function onMove(PlayerMoveEvent $event){
        $player = $event->getPlayer();
        $currentPos = $event->getTo();
        $lastPos = $event->getFrom();
        $speedXZ = (new Vector3($currentPos->x - $lastPos->x, 0, $currentPos->z - $lastPos->z))->length();
        $this->lastPositions[$player->getName()] = $currentPos;

        $session = Session::get($player);
        if ($session == null) return;

        if ($player->isCreative() || $player->isSpectator()) return;

        if ($session->getMotionTicks() < 40) return;

        if ($player->getEffects()->has(VanillaEffects::BLINDNESS()) && $player->isSprinting()){
             $this->flag($player, "Movement");
        } 
    }
    
    public function getPlayerLastPosition(Player $player): ?Vector3 {
        return $this->lastPositions[$player->getName()] ?? null;
    }
}