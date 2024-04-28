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
        return false;
    }

    public function onMove(PlayerMoveEvent $event): void {
        $player = $event->getPlayer();
        $session = Session::get($player);
        if ($session === null) return;

        $speed = Maths::getSpeed($player, $event->getFrom());
    }
}