<?php

namespace BhawaniTheKing;

use pocketmine\Server;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\Config;
use BhawaniTheKing\events\PlayerEvents;

class Main extends PluginBase implements Listener
{
    public static Main $instance;
    
    public function onEnable(): void
    {
        self::$instance = $this; 
        $this->initResources();
        
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        
        $this->getServer()->getPluginManager()->registerEvents(new PlayerEvents(), $this);
    }
    
    public static function getInstance(): Main
    {
        return self::$instance;
    }
    
    public static function getConfigFile(): Config
    {
        return new Config(self::getInstance()->getDataFolder() . "config.yml", Config::YAML); 
    }
    
    public function initResources(): bool 
    { 
        @mkdir($this->getDataFolder()); 
        @$this->saveResource("config.yml"); 
        if (!file_exists($this->getDataFolder() . "config.yml")) 
        {
            $this->getLogger()->error("Unable To Load Configuration, Please Verify That The File Exists !"); 
            return false;
        } 
        return true; 
    }
    
    public function onLoad(): void
    {
        $this->saveConfig();
    }
}
