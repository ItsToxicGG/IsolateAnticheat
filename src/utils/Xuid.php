<?php
declare(strict_types=1);

namespace Toxic\utils;

use pocketmine\player\Player;
use pocketmine\Server;

class Xuid {

	/**
	 * Returns an online player with the given xuid, or null if not found.
	 */
	public static function getPlayerByXuid(string $xuid) : ?Player{
		foreach(Server::getInstance()->getOnlinePlayers() as $player){
			if($player->getXuid() === $xuid){
				return $player;
			}
		}
		return null;
	}
}