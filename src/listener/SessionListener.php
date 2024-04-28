<?php

namespace Toxic\listener;

use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\PlayerAuthInputPacket;
use pocketmine\network\mcpe\protocol\types\PlayerAuthInputFlags;
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
}