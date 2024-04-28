<?php

namespace Toxic\listener;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityMotionEvent;
use pocketmine\event\entity\EntityTeleportEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerJumpEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\player\PlayerToggleFlightEvent;
use pocketmine\event\player\PlayerToggleGlideEvent;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\PlayerAuthInputPacket;
use pocketmine\network\mcpe\protocol\types\PlayerAuthInputFlags;
use pocketmine\player\Player;
use Toxic\network\constants\InputConstants;
use Toxic\Session;

class SessionListener implements Listener {

    public function onPacketRecieve(DataPacketReceiveEvent $event){
        $packet = $event->getPacket();
		$player = $event->getOrigin()->getPlayer();
		if ($player === null) {
			return;
		}
        $session = Session::get($player);
        if ($session === null) return;

        if ($packet instanceof PlayerAuthInputPacket){
            $inputMode = $packet->getInputMode();
            $session->setInput($inputMode);
            if (InputConstants::hasFlag($packet, PlayerAuthInputFlags::JUMPING)){
                $session->setJumping(true);
            } else {
                $session->setJumping(false);
            }
         }
    }

    public function onTeleport(EntityTeleportEvent $event){
        $player = $event->getEntity();
        if (!$player instanceof Player) return;
        $session = Session::get($player);
        if ($session === null) return;
        $session->setTeleportTicks();
    }

    public function onMove(PlayerMoveEvent $event){
        $player = $event->getPlayer();
        $session = Session::get($player);
        if ($session === null) return;
        $session->setMovementTicks();
    }

    public function onJump(PlayerJumpEvent $event){
        $player = $event->getPlayer();
        $session = Session::get($player);
        if ($session === null) return;
        $session->setJumpTicks();
    }

    public function onAttack(EntityDamageByEntityEvent $event) : void{
        $entity = $event->getEntity();
        $damager = $event->getDamager();
        if ($entity instanceof Player){
            $esession = Session::get($entity);
            if ($esession === null) return;
            switch($event->getCause()){
                case EntityDamageEvent::CAUSE_ENTITY_EXPLOSION:
                case EntityDamageEvent::CAUSE_BLOCK_EXPLOSION:
                    $esession->setBlastAttackTicks();
                    break;
                default:
                    $esession->setAttackTicks();
            }
        }
        if ($damager instanceof Player){
            $session = Session::get($damager);
            if ($session === null) return;
            $session->setAttackingTicks();
        }
    }

    public function onJoin(PlayerJoinEvent $event){
        $player = $event->getPlayer();
        $session = Session::get($player);
        if ($session === null) return;
        $session->setOnlineTicks();
    }

    public function onQuit(PlayerQuitEvent $event){
        $player = $event->getPlayer();
        $session = Session::get($player);
        if ($session === null) return;
        $playerId = $player->getUniqueId()->toString();
        unset($session->deathTicks[$playerId]);
        unset($session->onlineTicks[$playerId]);
    }

    public function onDeath(PlayerDeathEvent $event){
        $player = $event->getPlayer();
        $session = Session::get($player);
        if ($session === null) return;
        $session->setDeathTicks();
    }

    public function onChat(PlayerChatEvent $event){
        $player = $event->getPlayer();
        $session = Session::get($player);
        if ($session === null) return;
        $session->setChatTicks();
    }
    
    public function onMotion(EntityMotionEvent $event){
        $player = $event->getEntity();
        if (!$player instanceof Player) return;
        $session = Session::get($player);
        if ($session === null) return;
        ## Prevent Motion from jumping
        if ($session->isJumping()) return;
        $session->setMotionTicks();
    }
    
    public function onGlide(PlayerToggleGlideEvent $event){
        $player = $event->getPlayer();
        $session = Session::get($player);
        if ($session === null) return;
        $session->setGlideTicks();
    }

    public function onFlight(PlayerToggleFlightEvent $event){
        $player = $event->getPlayer();
        $session = Session::get($player);
        if ($session === null) return;
        $session->setFlightTicks();
    }

    public function onPlace(PlayerToggleFlightEvent $event){
        $player = $event->getPlayer();
        $session = Session::get($player);
        if ($session === null) return;
        $session->setPlacingTicks();
    }

    public function onBreak(PlayerToggleFlightEvent $event){
        $player = $event->getPlayer();
        $session = Session::get($player);
        if ($session === null) return;
    }
}