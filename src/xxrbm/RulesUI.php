<?php

declare(strict_types = 1);

namespace xxrbm;

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

use pocketmine\player\Player;

use pocketmine\utils\Config;

use xxrbm\forms\SimpleForm;

use xxrbm\Loader;

class RulesUI {

    private Loader $plugin;

    public function __construct(Loader $plugin) {
        $this->plugin = $plugin;
    }

    public function openUI(Player $sender) { 
        $form = new SimpleForm(function (Player $sender, int $data = null) {
            $result = $data;
            if ($result === null) {
                return true;
            }             
            switch($result) {
                case 0:
                    if ($this->getPlugin()->cfg->getNested("settings.msg-close", true)) {
                        $sender->sendMessage($this->getPlugin()->msg->getNested("messages.close"));
                    }
                break;
            }
        });

        $form->setTitle($this->getPlugin()->msg->getNested("rules.title"));
        $form->setContent($this->getPlugin()->msg->getNested("rules.content"));

        if ($this->getPlugin()->cfg->getNested("settings.btn-image", true)) {
            $form->addButton($this->getPlugin()->msg->getNested("btn.close"), $this->getPlugin()->msg->getNested("btn.type"), $this->getPlugin()->msg->getNested("btn.icon"));
        } else {
            $form->addButton($this->getPlugin()->msg->getNested("btn.close"));
        }

        $form->sendToPlayer($sender);
        return $form;
    }

    public function getPlugin() : Loader {
        return $this->plugin;
    }

}