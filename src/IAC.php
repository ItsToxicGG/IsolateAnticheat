<?php

namespace Toxic;

#PMMP
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;

#IAC
use Toxic\checks\CheckListener;
use Toxic\checks\Registery;
use Toxic\listener\SessionListener;

class IAC extends PluginBase implements Listener {

    protected function onEnable(): void{
        ##Events
        $this->getServer()->getPluginManager()->registerEvents(new CheckListener(), $this);
        $this->getServer()->getPluginManager()->registerEvents(new SessionListener(), $this);
        ##Register
        Registery::register();
    }
}