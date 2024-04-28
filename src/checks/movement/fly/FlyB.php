<?php

namespace Toxic\checks\movement\fly;

use pocketmine\block\VanillaBlocks;
use pocketmine\entity\effect\VanillaEffects;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use Toxic\checks\Check;
use Toxic\Session;
use Toxic\utils\Blocks;

class FlyB extends Check {

    public function getId(): int{
        return 2;
    }

    public function getName(): string{
        return "Fly";
    }

    public function getMaxViolations(): int{
        return 5;
    }

    public function getSubtype(): string{
        return "B";
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

        # False kick prevention
        if (
            $session->getAttackTicks() < 40 ||
            $session->getTeleportTicks() < 40 ||
            $session->getMotionTicks() < 30 ||
            $this->bypass($player) ||
            Blocks::isInBlock($player, VanillaBlocks::COBWEB()) ||
            Blocks::isInBlock($player, VanillaBlocks::WATER()) ||
            Blocks::isInBlock($player, VanillaBlocks::LAVA()) ||
            Blocks::isOnClimbable($player) ||
            $player->getAllowFlight()         
        ){
            return;
        }
    
        $airAround = Blocks::isInAir($player);

        // isOnGround can be bypassable by clients..
        if ($airAround || !$player->isOnGround()){
            if ($player->getInAirTicks() > 25) {
                $this->flag($player, "Movement");
            } 
        }
    }
}