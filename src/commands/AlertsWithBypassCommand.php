<?php

declare(strict_types=1);

namespace Toxic\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use Toxic\Session;

class AlertsWithBypassCommand extends Command {

    public function __construct() {
        parent::__construct("alertswithbypass", "get alerts with op command", "/alertswithbypass");
        $this->setAliases(["alerts", "awb", "noopbypass"]);
        $this->setPermission("iac.bypass");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
        if ($sender instanceof Player) {
            $ses = Session::get($sender);
            if ($ses->hasCheckAlertsWithBypass()){
                 $ses->setCheckAlertsWithBypass(false);
                 $player->sendMessage("You are bypassed with op");
            } else {
                $ses->setCheckAlertsWithBypass(true);
                $player->sendMessage("You are no longer bypassed with op");
            }
            return true;
        } else {
            $sender->sendMessage("This command can only be used in-game.");
            return false;
        }
    }
}
