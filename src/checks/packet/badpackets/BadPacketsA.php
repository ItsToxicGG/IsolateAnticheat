<?php

namespace DAC\checks\packet\badpackets;

use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\player\Player;
use Toxic\checks\Check;
use Toxic\Session;
use Toxic\utils\Maths;

class BadPacketsA extends Check {
    public function getId(): int{
        return 6;
    }

    public function getName(): string{
        return "BadPackets";
    }

    public function getMaxViolations(): int{
        return 5;
    }

    public function getSubtype(): string{
        return "A";
    }

    public function getType(): string{
        return "Exploit";
    }

    public function kick(): bool{
        return true;
    }

    public function onDamageBy(EntityDamageByEntityEvent $event): void {
        $entity = $event->getEntity();
        $damager = $event->getDamager();

        if (!$entity instanceof Player || !$damager instanceof Player) return;

        if ($entity->getId() == $damager->getId() || $damager->getId() == $entity->getId()){
            $this->flag($damager ?? $entity, $this->getType());
        }
    }
}