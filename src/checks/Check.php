<?php

namespace Toxic\checks;

use pocketmine\event\Listener;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat as TF;
use pocketmine\Server;
use Toxic\IAC;

abstract class Check {

    public const PREFIX = TF::BLACK . "[" . TF::DARK_PURPLE . "Isolate" . TF::BLACK . "]" . TF::RESET . " ";

    public static array $enabledChecks = [];
    public static array $allChecks = [];

    ## Subtype - {check-name}-{subtype}, example: Fly-A
    abstract public function getSubtype(): string;
    ## Name - {check-name}, example Fly
    abstract public function getName(): string;
    # Max violations before kick - if kick is enabled for the check
    abstract public function getMaxViolations(): int;
    # Optional for a check just to flag the player or kick the player
    abstract public function kick(): bool;
    # Id - must be special
    abstract public function getId(): int;
    # Type - no description
    abstract public function getType(): string;

    public array $flag = [];
    public array $lastFlag = [];

    public static function add(Check $check){
        self::$enabledChecks[] = $check;
        self::$allChecks[] = $check;
    }

    public static function remove(Check $check){
        $key = array_search($check, self::$enabledChecks, true);
        if ($key !== false) {
            unset(self::$enabledChecks[$key]);
        }
    }
 
    public function flag(Player $player, string $type, ?string $debug = null){
        if (!isset($this->flag[$player->getUniqueId()->__toString()][$this->getId()])) {
			$this->flag[$player->getUniqueId()->__toString()][$this->getId()] = 1;
		}

        $uuid = $player->getUniqueId()->__toString();

        $flagged = $this->flag[$uuid][$this->getId()];

        if ($flagged > $this->getMaxViolations()){ 
            $this->emptyFlags($player, $type, $this->getId());
            $this->notify($player, true);
 
            if (!$this->kick()) return;
            IAC::getInstance()->getLogger()->info(Check::PREFIX . TF::WHITE . $player->getName() . " " . TF::DARK_RED . "has been kicked " . TF::AQUA . "[" . $this->getType() . "]" . TF::RESET . " " . TF::DARK_PURPLE . $this->getName() . TF::AQUA . "/" . TF::WHITE . $this->getSubtype() . ". " . TF::WHITE . "[" . TF::BLACK . "x" . TF::BLUE . $this->flag[$uuid][$this->getId()] . TF::WHITE . "]");
            $player->kick(TF::DARK_GRAY . "You were kicked from the game: " . self::PREFIX . ">> " . TF::GOLD . "Unfair Advantage. " . TF::BLACK . "[" . TF::DARK_RED . $this->getName() . TF::BLACK . "]");
        } else {
            $this->notify($player);
            IAC::getInstance()->getLogger()->info(Check::PREFIX . TF::WHITE . $player->getName() . " " . TF::DARK_RED . "has failed " . TF::AQUA . "[" . $this->getType() . "]" . TF::RESET . " " . TF::DARK_PURPLE . $this->getName() . TF::AQUA . "/" . TF::WHITE . $this->getSubtype() . ". " . TF::WHITE . "[" . TF::BLACK . "x" . TF::BLUE . $this->flag[$uuid][$this->getId()] . TF::WHITE . "]");
            $this->flag[$player->getUniqueId()->__toString()][$this->getId()] += 1;
			if (!isset($this->lastFlag[$player->getUniqueId()->__toString()][$this->getId()])) {
				$this->lastFlag[$player->getUniqueId()->__toString()][$this->getId()] = microtime(true);
			}
        }
    }

    public function emptyFlags(Player $player, string $type, int $id){
        $uuid = $player->getUniqueId()->__toString();
        unset($this->flag[$uuid][$id]);
        $this->flag[$uuid][$id] = 0;
    }

    public function notify(Player $player, bool $kick = false){
        foreach (Server::getInstance()->getOnlinePlayers() as $staff) {
            $uuid = $player->getUniqueId()->__toString();            
            if ($this->bypass($staff)){
                if (!$kick){
                    $player->sendMessage(self::PREFIX . TF::WHITE . $player->getName() . " " . TF::DARK_RED . "has failed " . TF::AQUA . "[" . $this->getType() . "]" . TF::RESET . " " . TF::DARK_PURPLE . $this->getName() . TF::AQUA . "/" . TF::WHITE . $this->getSubtype() . ". " . TF::WHITE . "[" . TF::BLACK . "x" . TF::BLUE . $this->flag[$uuid][$this->getId()] . TF::WHITE . "]");
                } else {
                    $player->sendMessage(self::PREFIX . TF::WHITE . $player->getName() . " " . TF::DARK_RED . "has been kicked " . TF::AQUA . "[" . $this->getType() . "]" . TF::RESET . " " . TF::DARK_PURPLE . $this->getName() . TF::AQUA . "/" . TF::WHITE . $this->getSubtype() . ". " . TF::WHITE . "[" . TF::BLACK . "x" . TF::BLUE . $this->flag[$uuid][$this->getId()] . TF::WHITE . "]");
                }
            }
		}
    }

    public function bypass(Player $player): bool{
        return $player->hasPermission("iac.bypass");
    }
}