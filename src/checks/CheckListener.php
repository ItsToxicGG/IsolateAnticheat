<?php

namespace Toxic\checks;

use pocketmine\event\player\{PlayerInteractEvent, PlayerItemConsumeEvent, PlayerMoveEvent, PlayerToggleSwimEvent, PlayerToggleGlideEvent, PlayerBedEnterEvent, PlayerJumpEvent, PlayerQuitEvent, PlayerKickEvent, PlayerJoinEvent, PlayerDeathEvent};
use pocketmine\event\entity\{EntityDamageByEntityEvent, EntityDamageEvent, EntityRegainHealthEvent, EntityTeleportEvent, ProjectileHitEvent};
use pocketmine\event\block\{BlockPlaceEvent, BlockBreakEvent};
use pocketmine\event\player\PlayerRespawnEvent;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\event\inventory\{InventoryOpenEvent, InventoryCloseEvent, InventoryTransactionEvent};

use pocketmine\event\Listener;

class CheckListener implements Listener {

    public function getChecks(): array{
        return Check::$enabledChecks;
    }

    public function movement(PlayerMoveEvent $event){
        foreach ($this->getChecks() as $check){
            if (method_exists($check, 'onMove')) {
                $check->onMove($event);
            }
        }
    }

    public function interact(PlayerInteractEvent $event){
        foreach ($this->getChecks() as $check){
            if (method_exists($check, 'onInteract')) {
                $check->onInteract($event);
            }
        }
    }

    public function consume(PlayerItemConsumeEvent $event){
        foreach ($this->getChecks() as $check){
            if (method_exists($check, 'onConsume')) {
                $check->onConsume($event);
            }
        }
    }

    public function quit(PlayerQuitEvent $event){
        foreach ($this->getChecks() as $check){
            if (method_exists($check, 'onQuit')) {
                $check->onQuit($event);
            }
        }
    }

    public function death(PlayerDeathEvent $event){
        foreach ($this->getChecks() as $check){
            if (method_exists($check, 'onDeath')) {
                $check->onDeath($event);
            }
            if (method_exists($check, 'onPlayerDeath')) {
                $check->onPlayerDeath($event);
            }
        }
    }

    public function respawn(PlayerRespawnEvent $event){
        foreach ($this->getChecks() as $check){
            if (method_exists($check, 'onRespawn')) {
                $check->onRespawn($event);
            }
        }
    }

    public function kick(PlayerKickEvent $event){
        foreach ($this->getChecks() as $check){
            if (method_exists($check, 'onKick')) {
                $check->onKick($event);
            }
        }
    }


    public function jump(PlayerJumpEvent $event){
        foreach ($this->getChecks() as $check){
            if (method_exists($check, 'onJump')) {
                $check->onJump($event);
            }
        }
    }

    public function toggleS(PlayerToggleSwimEvent $event){
        foreach ($this->getChecks() as $check){
            if (method_exists($check, 'onToggleSwim')) {
                $check->onToggleSwim($event);
            }
        }
    }

    public function toggleG(PlayerToggleGlideEvent $event){
        foreach ($this->getChecks() as $check){
            if (method_exists($check, 'onToggleGlide')) {
                $check->onToggleGlide($event);
            }
        }
    }

    public function toggleB(PlayerBedEnterEvent $event){
        foreach ($this->getChecks() as $check){
            if (method_exists($check, 'onToggleBed')) {
                $check->onToggleBed($event);
            }
        }
    }

    public function damage(EntityDamageEvent $event){
        foreach ($this->getChecks() as $check){
            if (method_exists($check, 'onDamage')) {
                $check->onDamage($event);
            }
        }
    }

    public function damageB(EntityDamageByEntityEvent $event){
        foreach ($this->getChecks() as $check){
            if (method_exists($check, 'onDamageBy')) {
                $check->onDamageBy($event);
            } else if (method_exists($check, "onDamage")){
                $check->onDamage($event);
            }
        }
    }

    public function regen(EntityRegainHealthEvent $event){
        foreach ($this->getChecks() as $check){
            if (method_exists($check, 'onRegen')) {
                $check->onRegen($event);
            }
        }
    }

    public function teleport(EntityTeleportEvent $event){
        foreach ($this->getChecks() as $check){
            if (method_exists($check, 'onTeleport')) {
                $check->onTeleport($event);
            }
        }
    }

    public function projectileh(ProjectileHitEvent $event){
        foreach ($this->getChecks() as $check){
            if (method_exists($check, 'onProjectileHit')) {
                $check->onProjectileHit($event);
            }
        }
    }

    public function place(BlockPlaceEvent $event){
        foreach ($this->getChecks() as $check){
            if (method_exists($check, 'onPlace')) {
                $check->onPlace($event);
            }
        }
    }

    public function break(BlockBreakEvent $event){
        foreach ($this->getChecks() as $check){
            if (method_exists($check, 'onBreak')) {
                $check->onBreak($event);
            }
        }
    }

    public function packets(DataPacketReceiveEvent $event){
        foreach ($this->getChecks() as $check){
            if (method_exists($check, 'onReceivePackets')) {
                $check->onReceivePackets($event);
            }
        }
    }

    public function invO(InventoryOpenEvent $event){
        foreach ($this->getChecks() as $check){
            if (method_exists($check, 'invOpen')) {
                $check->invOpen($event);
            }
        }
    }

    public function invC(InventoryCloseEvent $event){
        foreach ($this->getChecks() as $check){
            if (method_exists($check, 'invClose')) {
                $check->invClose($event);
            }
        }
    }

    public function invI(InventoryTransactionEvent $event){
        foreach ($this->getChecks() as $check){
            if (method_exists($check, 'invTransaction')) {
                $check->invTransaction($event);
            }
        }
    }
}