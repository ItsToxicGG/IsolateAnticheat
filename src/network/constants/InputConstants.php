<?php

namespace Toxic\network\constants;

use pocketmine\network\mcpe\protocol\PlayerAuthInputPacket;

class InputConstants {

    public static function hasFlag(PlayerAuthInputPacket $packet, ...$flags): bool {
		foreach ($flags as $flag) {
			if (($packet->getInputFlags() & (1 << $flag)) !== 0) {
				return true;
			}
		}
		return false;
	}
}