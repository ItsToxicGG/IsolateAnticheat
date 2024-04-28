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

    ## Ticks

    public array $teleportTime = [];
    public array $attackTime = [];
    public array $jumpTime = [];
    public array $placingTime = [];
    public array $deathTicks = [];
    public array $blastAttackTime = [];
    public array $onlineTicks = [];
    public array $slimeTicks = [];
    public array $movementTicks = [];
    public array $flightTicks = [];
    public array $phaseTicks = [];
    public array $attackingTicks = [];
    public array $glideTicks = [];
    public array $motionTicks = [];
    public array $chatTicks = [];
    
    public function getTeleportTicks(): float {
        $player = $this->getPlayer();
        $playerId = $player->getUniqueId()->toString();
        $currentTime = microtime(true) * 20;
    
        return isset($this->teleportTime[$playerId])
            ? $currentTime - $this->teleportTime[$playerId]
            : PHP_FLOAT_MAX;
    }
    
    public function setTeleportTicks(): void {
        $player = $this->getPlayer();
        $playerId = $player->getUniqueId()->toString();
        $this->teleportTime[$playerId] = microtime(true) * 20;
    }
    
    public function getAttackTicks(): float {
        $player = $this->getPlayer();
        $playerId = $player->getUniqueId()->toString();
        $currentTime = microtime(true) * 20;
    
        return isset($this->attackTime[$playerId])
            ? $currentTime - $this->attackTime[$playerId]
            : PHP_FLOAT_MAX;
    }
    
    public function setAttackTicks(): void {
        $player = $this->getPlayer();
        $playerId = $player->getUniqueId()->toString();
        $this->attackTime[$playerId] = microtime(true) * 20;
    }
    
    public function getBlastAttackTicks(): float {
        $player = $this->getPlayer();
        $playerId = $player->getUniqueId()->toString();
        $currentTime = microtime(true) * 20;
    
        return isset($this->blastAttackTime[$playerId])
            ? $currentTime - $this->blastAttackTime[$playerId]
            : PHP_FLOAT_MAX;
    }
    
    public function setBlastAttackTicks(): void {
        $player = $this->getPlayer();
        $playerId = $player->getUniqueId()->toString();
        $this->blastAttackTime[$playerId] = microtime(true) * 20;
    }
    
    public function getJumpTicks(): float {
        $player = $this->getPlayer();
        $playerId = $player->getUniqueId()->toString();
        $currentTime = microtime(true) * 20;
    
        return isset($this->jumpTime[$playerId])
            ? $currentTime - $this->jumpTime[$playerId]
            : PHP_FLOAT_MAX;
    }
    
    public function setJumpTicks(): void {
        $player = $this->getPlayer();
        $playerId = $player->getUniqueId()->toString();
        $this->jumpTime[$playerId] = microtime(true) * 20;
    }
    
    public function getPlacingTicks(): float {
        $player = $this->getPlayer();
        $playerId = $player->getUniqueId()->toString();
        $currentTime = microtime(true) * 20;
    
        return isset($this->placingTime[$playerId])
            ? $currentTime - $this->placingTime[$playerId]
            : PHP_FLOAT_MAX;
    }
    
    public function setPlacingTicks(): void {
        $player = $this->getPlayer();
        $playerId = $player->getUniqueId()->toString();
        $this->placingTime[$playerId] = microtime(true) * 20;
    }
    
    public function getDeathTicks(): float {
        $player = $this->getPlayer();
        $playerId = $player->getUniqueId()->toString();
        $currentTime = microtime(true) * 20;
    
        return isset($this->deathTicks[$playerId])
            ? $currentTime - $this->deathTicks[$playerId]
            : 0.0;
    }
    
    public function setDeathTicks(): void {
        $player = $this->getPlayer();
        $playerId = $player->getUniqueId()->toString();
        $this->deathTicks[$playerId] = microtime(true) * 20;
    }
    
    public function getOnlineTicks(): float {
        $player = $this->getPlayer();
        $playerId = $player->getUniqueId()->toString();
        $currentTime = microtime(true) * 20;
    
        return isset($this->onlineTicks[$playerId])
            ? $currentTime - $this->onlineTicks[$playerId]
            : 0.0;
    }
    
    public function setOnlineTicks(): void {
        $player = $this->getPlayer();
        $playerId = $player->getUniqueId()->toString();
        $this->onlineTicks[$playerId] = microtime(true) * 20;
    }
    
    public function getSlimeTicks(): float {
        $player = $this->getPlayer();
        $playerId = $player->getUniqueId()->toString();
        $currentTime = microtime(true) * 20;
    
        return isset($this->slimeTicks[$playerId])
            ? $currentTime - $this->slimeTicks[$playerId]
            : PHP_FLOAT_MAX;
    }
    
    public function setSlimeTicks(): void {
        $player = $this->getPlayer();
        $playerId = $player->getUniqueId()->toString();
        $this->slimeTicks[$playerId] = microtime(true) * 20;
    }
    
    public function getMovementTicks(): float {
        $player = $this->getPlayer();
        $playerId = $player->getUniqueId()->toString();
        $currentTime = microtime(true) * 20;
    
        return isset($this->movementTicks[$playerId])
            ? $currentTime - $this->movementTicks[$playerId]
            : PHP_FLOAT_MAX;
    }
    
    public function setMovementTicks(): void {
        $player = $this->getPlayer();
        $playerId = $player->getUniqueId()->toString();
        $this->movementTicks[$playerId] = microtime(true) * 20;
    }
    
    public function getFlightTicks(): float {
        $player = $this->getPlayer();
        $playerId = $player->getUniqueId()->toString();
        $currentTime = microtime(true) * 20;
    
        return isset($this->flightTicks[$playerId])
            ? $currentTime - $this->flightTicks[$playerId]
            : PHP_FLOAT_MAX;
    }
    
    public function setFlightTicks(): void {
        $player = $this->getPlayer();
        $playerId = $player->getUniqueId()->toString();
        $this->flightTicks[$playerId] = microtime(true) * 20;
    }
    
    public function getPhaseTicks(): float {
        $player = $this->getPlayer();
        $playerId = $player->getUniqueId()->toString();
        $currentTime = microtime(true) * 20;
    
        return isset($this->phaseTicks[$playerId])
            ? $currentTime - $this->phaseTicks[$playerId]
            : PHP_FLOAT_MAX;
    }
    
    public function setPhaseTicks(): void {
        $player = $this->getPlayer();
        $playerId = $player->getUniqueId()->toString();
        $this->phaseTicks[$playerId] = microtime(true) * 20;
    }
    
    public function getAttackingTicks(): float {
        $player = $this->getPlayer();
        $playerId = $player->getUniqueId()->toString();
        $currentTime = microtime(true) * 20;
    
        return isset($this->attackingTicks[$playerId])
            ? $currentTime - $this->attackingTicks[$playerId]
            : PHP_FLOAT_MAX;
    }
    
    public function setAttackingTicks(): void {
        $player = $this->getPlayer();
        $playerId = $player->getUniqueId()->toString();
        $this->attackingTicks[$playerId] = microtime(true) * 20;
    }
    
    public function getGlideTicks(): float {
        $player = $this->getPlayer();
        $playerId = $player->getUniqueId()->toString();
        $currentTime = microtime(true) * 20;
    
        return isset($this->glideTicks[$playerId])
            ? $currentTime - $this->glideTicks[$playerId]
            : PHP_FLOAT_MAX;
    }
    
    public function setGlideTicks(): void {
        $player = $this->getPlayer();
        $playerId = $player->getUniqueId()->toString();
        $this->glideTicks[$playerId] = microtime(true) * 20;
    }
    
    public function getMotionTicks(): float {
        $player = $this->getPlayer();
        $playerId = $player->getUniqueId()->toString();
        $currentTime = microtime(true) * 20;
    
        return isset($this->motionTicks[$playerId])
            ? $currentTime - $this->motionTicks[$playerId]
            : PHP_FLOAT_MAX;
    }
    
    public function setMotionTicks(): void {
        $player = $this->getPlayer();
        $playerId = $player->getUniqueId()->toString();
        $this->motionTicks[$playerId] = microtime(true) * 20;
    }
    
    public function getChatTicks(): float {
        $player = $this->getPlayer();
        $playerId = $player->getUniqueId()->toString();
        $currentTime = microtime(true) * 20;
    
        return isset($this->chatTicks[$playerId])
            ? $currentTime - $this->chatTicks[$playerId]
            : PHP_FLOAT_MAX;
    }
    
    public function setChatTicks(): void {
        $player = $this->getPlayer();
        $playerId = $player->getUniqueId()->toString();
        $this->chatTicks[$playerId] = microtime(true) * 20;
    }
}