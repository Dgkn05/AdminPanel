<?php

/*
*  _   _____             _        ______
* (_)/ ____|           | |      |___  /
*  _| (___  _ __   ___ | | _____   / /
* | |\___ \| '_ \ / _ \| |/ / _ \ / /
* | |____) | |_) | (_) |   <  __// /__
* |_|_____/| .__/ \___/|_|\_\___/_____|
*          | |
*          |_|
*
*@author iSpokeZ (Umut Yıldırım)
*
*@RainzGG Tüm Hakları Saklıdır!
*
*@Eklenti Umut Yıldırım Tarafından Özel Olarak Kodlanmıştır.
*
*@YouTube - iSpokeZ
*
*/

namespace iSpokeZ;

use pocketmine\plugin\PluginBase;
use pocketmine\plugin\Plugin;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\Server;
use pocketmine\Player;
use jojoe77777\FormAPI;
use pocketmine\math\Vector3;
use pocketmine\item\Item;
use pocketmine\level\particle\FlameParticle;
use pocketmine\level\sound\BlazeShootSound;

class AdminPanel extends PluginBase {

    public function onEnable(){
        $this->getLogger()->info("§7> §aAktif");
    }

    public function onDisable(){
        $this->getLogger()->info("§7> §cDe-Aktif");
    }

    public function onCommand(CommandSender $o, Command $kmt, string $label, array $args): bool {
        switch($kmt->getName()){
            case "apanel":
                if(!$o->hasPermission("apanel.kmt")){
                    $o->sendMessage("§cYetkin Yok!");
                    return true;
        }
                $this->panelForm($o);
     }
    return true;
    }

    public function panelForm(Player $o){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createSimpleForm(function(Player $o, array $data){
            $result = $data[0];
            if($result === null){
                return true;
            }
            switch($result){
                case 0:
                    $this->omForm($o);
                    break;
                case 1:
                    $this->kickForm($o);
                    break;
                case 2:
                    $this->timeForm($o);
                    break;
                case 3:
                    $this->banForm($o);
                    break;
                case 4:
                    $this->sayForm($o);
                    break;
                case 5:
                    $this->stForm($o);
                    break;
                case 6:
                    $this->flyForm($o);
                    break;
                case 7:
                    break;
            }
        });
        $form->setTitle("§3Admin Paneli");
        $form->setContent("§eAşağıdaki Butonlardan Istediğin Işlemi Yapabilirsin!");
        $form->addButton("§cOyun Modunu Değiştir\n§7Tıkla", 0,"textures/items/paper");
        $form->addButton("§cOyuncu At\n§7Tıkla", 0,"textures/items/paper");
        $form->addButton("§cZamanı Ayarla\n§7Tıkla", 0,"textures/items/paper");
        $form->addButton("§cOyuncu Banla\n§7Tıkla", 0,"textures/items/paper");
        $form->addButton("§cDuyuru Yap\n§7Tıkla", 0,"textures/items/paper");
        $form->addButton("§cSohbeti Temizle\n§7Tıkla", 0,"textures/items/paper");
        $form->addButton("§cUç\n§7Tıkla", 0,"textures/items/paper");
        $form->addButton("§4Menüden Ayrıl", 0,"textures/blocks/barrier");
        $form->sendToPlayer($o);
     }
     public function omForm(Player $o){
            $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
            $form = $api->createSimpleForm(function(Player $o, array $data){
                $result = $data[0];
                if($result === null){
                    return true;
                }
                switch($result){
                    case 0:
                        $o->setGamemode(1);
                        $o->getLevel()->addSound(new BlazeShootSound($o));
                        $o->getLevel()->addParticle(new FlameParticle($o));
                        $o->sendPopup("§aOyun Modun Güncellendi!");
                        break;
                    case 1:
                        $o->getLevel()->addSound(new BlazeShootSound($o));
                        $o->getLevel()->addParticle(new FlameParticle($o));
                        $o->setGamemode(0);
                        $o->sendPopup("§aOyun Modun Güncellendi");
                        break;
                    case 2:
                        $this->panelForm($o);
                        break;
                }
            });
            $form->setTitle("§3Oyun Modu Seçici");
            $form->setContent("§eAşağıdan Oyun Modunu Seçebilirsin");
            $form->addButton("§cYaratıcı Mod\n§7Tıkla");
            $form->addButton("§cHayatta Kalma Modu\n§7Tıkla");
            $form->addButton("§cGeri");
            $form->sendToPlayer($o);
        }

        public function kickForm(Player $o){
            $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
            $form = $api->createCustomForm(function(Player $o, array $data){
                $result = $data[0];
                if($result === null){
                    return true;
                }
                switch($result){
                    case 0:
                        $o->getLevel()->addSound(new BlazeShootSound($o));
                        $o->getLevel()->addParticle(new FlameParticle($o));
                        $this->playerName = $data[1];
                        $this->getServer()->getCommandMap()->dispatch($o, "kick " . $this->playerName);
                        break;
                }
            });
            $form->setTitle("§3Oyuncu Atma Menüsü");
            $form->addInput("§eAşağıya Atmak Istediğin Oyuncunun Adını Ve Sebebini Yaz !\n\n","§7Oyuncu Adı");
            $form->addLabel("");
            $form->sendToPlayer($o);
        }

        public function timeForm(Player $o){
            $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
            $form = $api->createSimpleForm(function(Player $o, array $data){
                $result = $data[0];
                if($result === null){
                    return true;
                }
                switch($result){
                    case 0:
                        $o->getLevel()->addSound(new BlazeShootSound($o));
                        $o->getLevel()->addParticle(new FlameParticle($o));
                        $this->getServer()->dispatchCommand($o, "time set day");
                        $o->sendPopup("§aSaat Ayarlandı");
                        break;
                    case 1:
                        $o->getLevel()->addSound(new BlazeShootSound($o));
                        $o->getLevel()->addParticle(new FlameParticle($o));
                        $this->getServer()->dispatchCommand($o, "time set night");
                        $o->sendPopup("§aSaat Ayarlandı");
                        break;
                    case 2:
                        $this->panelForm($o);
                        break;
                }
            });
            $form->setTitle("§3Saat Ayarlama Menüsü");
            $form->setContent("§eAşağıdaki Butonlardan Saati Ayarlayabilirsin");
            $form->addButton("§cSabah Yap\n§7Tıkla");
            $form->addButton("§cGece Yap\n§7Tıkla");
            $form->addButton("§cGeri");
            $form->sendToPlayer($o);
        }

        public function banForm(Player $o){
            $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
            $form = $api->createCustomForm(function(Player $o, array $data){
                $result = $data[0];
                if($result === null){
                    return true;
                }
                switch($result){
                    case 0:
                        $o->getLevel()->addSound(new BlazeShootSound($o));
                        $o->getLevel()->addParticle(new FlameParticle($o));
                        $this->playerName = $data[1];
                        $this->getServer()->getCommandMap()->dispatch($o, "ban " . $this->playerName);
                        break;
                }
            });
            $form->setTitle("§3Oyuncu Banlama Menüsü");
            $form->addInput("§eAşağıya Banlamak Istediğin Oyuncunun Adını Ve Sebebini Yaz !\n\n","§7Oyuncu Adı");
            $form->addLabel("");
            $form->sendToPlayer($o);
        }

        public function sayForm(Player $o){
            $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
            $form = $api->createCustomForm(function(Player $o, array $data){
                $result = $data[0];
                if($result === null){
                    return true;
                }
                switch($result){
                    case 0:
                        $o->getLevel()->addSound(new BlazeShootSound($o));
                        $o->getLevel()->addParticle(new FlameParticle($o));
                        $this->playerName = $data[1];
                        $this->getServer()->broadcastMessage("§l§9Rainz§7GG §c".implode(" ", $data));
                        break;
                    case 1:
                        $this->panelForm($o);
                        break;
                }
            });
            $form->setTitle("§3Duyuru Yapma Menüsü");
            $form->addInput("§eDuyuru Yapmak Için Bir Yazı Yaz\n\n","§7Yazı");
            $form->addLabel("");
            $form->sendToPlayer($o);
        }

        public function stForm(Player $o){
            $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
            $form = $api->createSimpleForm(function(Player $o, array $data){
                $result = $data[0];
                if($result === null){
                    return true;
                }
                switch($result){
                    case 0:
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $this->getServer()->BroadcastMessage(" ");
                        $o->sendPopup("§aSohbet Temizlendi");
                        $o->getLevel()->addSound(new BlazeShootSound($o));
                        $o->getLevel()->addParticle(new FlameParticle($o));
                        break;
                    case 1:
                        $this->panelForm($o);
                        break;
                }
            });
            $form->setTitle("§3Sohbet Temizleme Menüsü");
            $form->setContent("§eAşağıdaki Butona Basarak Sohbeti Temizleyebilirsin");
            $form->addButton("§cSohbeti Temizle\n§7Tıkla");
            $form->addButton("§cGeri");
            $form->sendToPlayer($o);
        }

        public function flyForm(Player $o){
            $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
            $form = $api->createSimpleForm(function(Player $o, array $data){
                $result = $data[0];
                if($result === null){
                    return true;
                }
                switch($result){
                    case 0:
                        $o->getLevel()->addSound(new BlazeShootSound($o));
                        $o->getLevel()->addParticle(new FlameParticle($o));
                        $o->setAllowFlight(true);
                        $o->addTitle("§eUç\n§aAktif");
                        break;
                    case 1:
                        $o->getLevel()->addSound(new BlazeShootSound($o));
                        $o->getLevel()->addParticle(new FlameParticle($o));
                        $o->setAllowFlight(false);
                        $o->addTitle("§eUç\n§cDe-Aktif");
                        break;
                }
            });
            $form->setTitle("§3Uçma Menüsü");
            $form->setContent("§eAşağıdaki Butona Basarak Uçma Işlemini Gerçekleştirebilirsin");
            $form->addButton("§cUçmayı Aktif Et\n§7Tıkla");
            $form->addButton("§cUçmayı De-Aktif Et\n§7Tıkla");
            $form->addButton("§cGeri");
            $form->sendToPlayer($o);
        }
    }