<?php

declare(strict_types = 1);

namespace xxrbm\commands;

/*
 *
 * Rules UI, a plugin for PocketMine-MP
 * Copyright (c) 2020-2022 Rendiansyah <worteldzgn@gmail.com>
 *
 * Poggit: https://poggit.pmmp.io/ci/Rendii09
 * Github: https://github.com/Rendii09
 * Website: https://rendiansyah.com
 *
 * License under "MIT"
 *
 */

use pocketmine\command\{Command,CommandSender};

use pocketmine\player\Player;

use pocketmine\utils\Config;

use xxrbm\Loader;

class RulesCommand extends Command {

    private Loader $plugin;

    public function __construct(Loader $plugin, string $desc, string $usage, array $aliases) {
        parent::__construct("rules", $desc, $usage, $aliases);
        $this->setPermission("rules.cmd");
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $label, array $args) : bool {
        if ($sender instanceof Player) {
            $this->getPlugin()->rls->openUI($sender);
        } else {
            $this->getPlugin()->getLogger()->error($this->getPlugin()->msg->getNested("messages.use-in-game"));
        }
        return true;
    }

    public function getPlugin() : Loader {
        return $this->plugin;
    }

}