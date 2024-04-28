<?php

namespace DAC\Checks\movement\noslow;

use pocketmine\block\BlockTypeIds;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use Toxic\checks\Check;
use Toxic\Session;

class NoSlowA extends Check {

    public function getId(): int{
        return 4;
    }

    public function getName(): string{
        return "NoSlow";
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

    public function isInsideWeb(Player $player): bool{
        $block = $player->getWorld()->getBlock($player->getLocation()->asVector3()->add(0, 0.75, 0));

	    if ($block->getTypeId() == BlockTypeIds::COBWEB){
	        return true;
	    }

	    return false;
    }

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

        if ($this->isInsideWeb($player)){
            if ($speedXZ > 2.4) {
                $this->flag($player, "Movement");
            }
        }
    }
    
    public function getPlayerLastPosition(Player $player): ?Vector3 {
        return $this->lastPositions[$player->getName()] ?? null;
    }
}