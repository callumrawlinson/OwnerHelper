<?php

namespace Owner;

use pocketmine\Server;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;
use pocketmine\entity\{Effect, EffectInstance, Entity};
use pocketmine\Player;
use UIAPI\{Form, ModalForm, SimpleForm, CustomForm};
use UIS\KickUI;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\CommandExecutor;
use pocketmine\command\ConsoleCommandSender;

class Owner extends PluginBase implements Listener {
	
    public function onEnable() {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);    
        $this->getLogger()->info(TextFormat::GREEN . "OwnerHelper was Activated");
    }
    public function onDisable() {
        $this->getLogger()->info(TextFormat::RED . "OwnerHelper was Deactivated");
    }
    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool {
        switch($cmd->getName()){                    
            case "ohelp":
                if ($sender->hasPermission("owner.command")){
                     $this->Menu($sender);
                }else{     
                     $sender->sendMessage(TextFormat::RED . "§You do not have permission to use the OwnerHelper UI");
                     return true;
                }     
            break;         
            
         }  
        return true;                         
    }
   
    public function Menu($sender){ 
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createSimpleForm(function (Player $sender, int $data = null){
            $result = $data;
            if($result === null){
			return true;
            }             
            switch($result){
               case 0:
$this->getServer()->dispatchCommand($sender, "motd");
                break;   
               case 1:
$this->getServer()->dispatchCommand($sender, "stop");
                break;   			
               case 2:
$this->getServer()->dispatchCommand($sender, "reload");
                break;   					    
            }
        });
        $form->setTitle("§f§lOwnerHelper");
        $form->setContent("§7A simple UserInterface that helps you manage your server");
        $form->addButton("§l§eChange MOTD\n§r§0Select",0,"textures/ui/conduit_power_effect");
	$form->addButton("§l§eStop Server\n§r§0Select",1,"textures/ui/conduit_power_effect");
	$form->addButton("§l§eReload\n§r§0Select",2,"textures/ui/conduit_power_effect");
        $form->sendToPlayer($sender);
            return $form;
    }
}
