<?php

/**
 * @name Gamemode
 * @main tjwls012\gamemode\Gamemode
 * @author ["tjwls012"]
 * @version 0.1
 * @api 3.13.0
 * @description License : LGPL 3.0
 */
 
namespace tjwls012\gamemode;
 
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;

use pocketmine\Player;
use pocketmine\event\player\PlayerJoinEvent;

use pocketmine\entity\Entity;
use pocketmine\event\entity\EntityLevelChangeEvent;

use pocketmine\level\Level;

class Gamemode extends PluginBase implements Listener{

  public $list = array("world" => 0, "island" => 0, "default" => 0);
  
  public $mode = 1; //0 : apply to op, 1 : apply to user(except op)
  
  public static $instance;
  
  public static function getInstance(){
  
    return self::$instance;
  }
  public function onLoad(){
  
    self::$instance = $this;
  }
  public function onEnable(){
  
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
  }
  public function onJoin(PlayerJoinEvent $e){
  
    $player = $e->getPlayer();
    
    $level = $player->getLevel();
    
    $this->setGamemode($player, $level);
  }
  public function onEntityLevelChange(EntityLevelChangeEvent $e){
  
    $entity = $e->getEntity();
    
    if($entity instanceof Player){
    
      $level = $e->getTarget();
      
      $this->setGamemode($entity, $level);
    }
  }
  public function setGamemode(Player $player, Level $level){
  
    $list = $this->list;
    $mode = $this->mode;
    
    $level_name = $level->getFolderName();
    
    if($player->isOp() and $mode == 1) return true;
    
    $int = $list["default"];
    
    if(isset($list[$level_name])){
    
      $int = $list[$level_name];
    }
    
    $player->setGamemode($int);
  }
}
