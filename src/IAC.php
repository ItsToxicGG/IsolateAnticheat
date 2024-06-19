<?php

namespace Toxic;

#PMMP
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;

#IAC
use Toxic\checks\CheckListener;
use Toxic\checks\Registery;
use Toxic\listener\SessionListener;
use Toxic\commands\AlertsWithBypassCommand;

class IAC extends PluginBase implements Listener {

    public static $instance;

    public function onLoad(): void{
        self::$instance = $this;
    }

    public static function getInstance(){
        return self::$instance;
    }

    protected function onEnable(): void{
        ##Events
        $this->getServer()->getPluginManager()->registerEvents(new CheckListener(), $this);
        $this->getServer()->getPluginManager()->registerEvents(new SessionListener(), $this);

        $this->getServer()->getCommandMap()->register("alertswithbypass", new AlertsWithBypassCommand());
        ##Register
        Registery::register();

        ## Log
        $this->getLogger()->notice("You are using an anticheat in Alpha, this is mean't for testing not yet for production servers!");
    }
}