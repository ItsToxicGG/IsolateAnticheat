<?php

namespace Toxic;

use pocketmine\entity\Location;
use pocketmine\player\Player;
use Toxic\utils\Xuid;

class Session {

	/** @var Session[] */
	public static array $sessions = [];

	public static function get(Player $player) : Session {
		return self::$sessions[$player->getUniqueId()->__toString()] ??= new Session($player->getXuid());
	}

	public static function remove(Player $player) : void {
		unset(self::$sessions[$player->getUniqueId()->__toString()]);
	}

    public function __construct(private string $xuid){
        // NOOP
     }
 
     public function getPlayer():?Player{
         return Xuid::getPlayerByXuid($this->xuid);
     }

     public bool $jumping = false;
     public int $input;
     private array $tags = [];

     public function isJumping(): bool{
        return $this->jumping;
     }

     public function setJumping(bool $value): void{
        $this->jumping = $value;
     }

     public function getInput(): int{
         return $this->input;
     }

     public function setInput(int $value): void{
        $this->input = $value;
     }

     
	public function getTag(string $tag) {
		if (isset($this->tags[$name = $this->xuid][$tag])) {
			return $this->tags[$name][$tag];
		}
		return null;
	}

	public function setTag(string $tag, mixed $value) : void {
		$this->tags[$this->xuid][$tag] = $value;
	}

	public function removeTag(string $tag) : void {
		if (isset($this->tags[$xuid = $this->xuid][$tag])) {
			unset($this->tags[$xuid][$tag]);
		}
	}

}