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

use pocketmine\plugin\PluginBase;

use pocketmine\utils\Config;

use pocketmine\Server;

use xxrbm\commands\RulesCommand;

use xxrbm\events\JoinUI;

use xxrbm\RulesUI;

class Loader extends PluginBase {

    public static Loader $instance;

    public Config $cfg;
    public Config $msg;

    public $rls;

    const CONFIG_VERSION = "2.0.0";
    const MESSAGES_VERSION = "1.0.0";

    public function onLoad() : void {
        self::$instance = $this;
    }

    public function onEnable() : void {
        $this->loadForms();
        $this->loadFiles();
        $this->loadEvents();
        $this->loadCommands();
        $this->checkVersion();
    }

    public function loadForms() : void {
        $this->rls = new RulesUI($this);
    }

    public function loadFiles() : void {
        $this->saveResource("config.yml");
        $this->saveResource("messages.yml");
        
        $this->cfg = new Config($this->getDataFolder() . "config.yml", Config::YAML);
        $this->msg = new Config($this->getDataFolder() . "messages.yml", Config::YAML);
    }

    public function loadEvents() : void {
        $events = [
            JoinUI::class
        ];

        foreach($events as $e) {
            $this->getServer()->getPluginManager()->registerEvents(new $e($this), $this);
        }
    }

    public function loadCommands() : void {
        $this->getServer()->getCommandMap()->register("rules", new RulesCommand($this, $this->cfg->getNested("commands.desc"), "/rules", $this->cfg->getNested("commands.aliases")));
    }

    private function checkVersion() : void {
        if ((!$this->cfg->exists("config-version")) || ($this->cfg->get("config-version") != Loader::CONFIG_VERSION)) {
            rename($this->getDataFolder() . "config.yml", $this->getDataFolder() . "config_old.yml");
            $this->getLogger()->notice("Your configuration file is outdate!");
            $this->getLogger()->notice("Your old configuration has been saved as config_old.yml and a new configuration file ha been generated. Please consider update.");
            $this->cfg->save();
        }

        if ((!$this->msg->exists("messages-version")) || ($this->msg->get("messages-version") != Loader::MESSAGES_VERSION)) {
            rename($this->getDataFolder() . "messages.yml", $this->getDataFolder() . "messages_old.yml");
            $this->getLogger()->notice("Your messages.yml file is outdate!");
            $this->getLogger()->notice("Your old messages.yml has been saved as messages_old.yml and a new configuration file ha been generated. Please consider update.");
            $this->msg->save();
        }
    }

    public static function getInstance() : Loader {
        return self::$instance;
    }

}
