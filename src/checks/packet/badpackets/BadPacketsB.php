<?php

namespace DAC\checks\packet\badpackets;

use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\PlayerAuthInputPacket;
use pocketmine\player\Player;
use Toxic\checks\Check;
use Toxic\Session;
use Toxic\utils\Maths;

class BadPacketsB extends Check {
    public function getId(): int{
        return 7;
    }

    public function getName(): string{
        return "BadPackets";
    }

    public function getMaxViolations(): int{
        return 5;
    }

    public function getSubtype(): string{
        return "B";
    }

    public function getType(): string{
        return "Rotation";
    }

    public function kick(): bool{
        return true;
    }

    public array $lastRotations = [];
    public array $lastDiff = [];

    public function onReceivePackets(DataPacketReceiveEvent $event): void {
        $packet = $event->getPacket();
        $player = $event->getOrigin()->getPlayer();
        if ($player == null) return;
        if ($packet instanceof PlayerAuthInputPacket) {
            $currentRotation = $packet->getYaw();
            
            $lastRotation = $this->lastRotations[spl_object_id($player)] ?? null;
            $lastYawDiff = $this->lastDiff[spl_object_id($player)] ?? null;
            
            if ($lastRotation !== null && $lastYawDiff !== null) {
                $yawDiff = abs($currentRotation - $lastRotation);
                
                $isDerpRotation =
                    ($yawDiff === 2 && $lastYawDiff === 4) ||
                    ($yawDiff === 4 && $lastYawDiff === 2) ||
                    ($yawDiff === 2 && $lastYawDiff === 2);
                
                if ($isDerpRotation) {
                    $this->flag($player, "Rotation");
                }
            }

            $this->lastRotations[spl_object_id($player)] = $currentRotation;
            $this->lastDiff[spl_object_id($player)] = $yawDiff ?? 0;
        }
    }
}