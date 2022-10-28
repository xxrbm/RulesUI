<?php

namespace xxrbm\events;

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

use pocketmine\event\{Listener,player\PlayerJoinEvent};

use pocketmine\player\Player;

use xxrbm\{Loader,RulesUI};

class JoinUI implements Listener {

    private Loader $plugin;

    public function __construct(Loader $plugin) {
        $this->plugin = $plugin;
    }

    public function onJoin(PlayerJoinEvent $event) {
        $sender = $event->getPlayer();
        if ($this->getPlugin()->cfg->getNested("settings.first-join", true)) {
            $this->getPlugin()->rls->openUI($sender);
        }
    }

    public function getPlugin() : Loader {
        return $this->plugin;
    }

}