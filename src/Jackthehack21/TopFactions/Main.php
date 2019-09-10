<?php
/*
 *  /$$$$$$$$                  /$$$$$$$$                   /$$     /$$
 * |__  $$__/                 | $$_____/                  | $$    |__/
 *    | $$  /$$$$$$   /$$$$$$ | $$    /$$$$$$   /$$$$$$$ /$$$$$$   /$$  /$$$$$$  /$$$$$$$   /$$$$$$$
 *    | $$ /$$__  $$ /$$__  $$| $$$$$|____  $$ /$$_____/|_  $$_/  | $$ /$$__  $$| $$__  $$ /$$_____/
 *    | $$| $$  \ $$| $$  \ $$| $$__/ /$$$$$$$| $$        | $$    | $$| $$  \ $$| $$  \ $$|  $$$$$$
 *    | $$| $$  | $$| $$  | $$| $$   /$$__  $$| $$        | $$ /$$| $$| $$  | $$| $$  | $$ \____  $$
 *    | $$|  $$$$$$/| $$$$$$$/| $$  |  $$$$$$$|  $$$$$$$  |  $$$$/| $$|  $$$$$$/| $$  | $$ /$$$$$$$/
 *    |__/ \______/ | $$____/ |__/   \_______/ \_______/   \___/  |__/ \______/ |__/  |__/|_______/
 *                  | $$
 *                  | $$
 *                  |__/
*
*   Copyright (C) 2019 Jackthehack21 (Jack Honour/Jackthehaxk21/JaxkDev)
*
*   This program is free software: you can redistribute it and/or modify
*   it under the terms of the GNU General Public License as published by
*   the Free Software Foundation, either version 3 of the License, or
*   any later version.
*
*   This program is distributed in the hope that it will be useful,
*   but WITHOUT ANY WARRANTY; without even the implied warranty of
*   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*   GNU General Public License for more details.
*
*   You should have received a copy of the GNU General Public License
*   along with this program.  If not, see <https://www.gnu.org/licenses/>.
*
*   Twitter :: @JaxkDev
*   Discord :: Jackthehaxk21#8860
*   Email   :: gangnam253@gmail.com
*/

declare(strict_types=1);
namespace Jackthehack21\TopFactions;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\math\Vector3;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

use pocketmine\utils\TextFormat as C;

use FactionsPro\FactionMain;
use SQLite3;

class Main extends PluginBase implements Listener{

    private $config;

    /** @var Config */
    private $configC;

    /** @var FloatingText[] */
    private $particles = [];

    /** @var Sqlite3 */
    private $db;

    public function onEnable() : void{
        $this->saveResource("config.yml");
        $this->configC = new Config($this->getDataFolder() . "config.yml", Config::YAML);
        $this->config = $this->configC->getAll();

        $FactionMain = $this->getServer()->getPluginManager()->getPlugin("FactionsPro");

        $this->db = $FactionMain->db;

        foreach($this->config["positions"] as $pos){
            $this->particles[] = new FloatingText($this, new Vector3($pos[0],$pos[1],$pos[2]));
        }

        $this->getScheduler()->scheduleRepeatingTask(new UpdateTask($this),$this->config["update_ticks"]); //update floating text every 5secs.
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
    {
        //todo possibly.
        return true;
    }

    private function getAllFactions() : array{
        $list = $this->db->query("SELECT * FROM strength;");
        $data = [];
        $countTmp = $list->fetchArray(1);
        while($countTmp !== false){
            $data[] = $countTmp;
            $countTmp = $list->fetchArray(1);
        }
        return $data;
    }

    public function getLeaderBoard() : string{
        $data = $this->getAllFactions();

        $keys = array_column($data, 'power');
        array_multisort($keys, SORT_ASC, $data);

        $result = array_slice(array_reverse($data), 0, 10);
        $return = "";
        $count = 1;
        foreach($result as $line){
            $return = $return.$this->colourise(TextFormat::colorize("&6Rank: &b$count, &6Faction: &b$line["faction"], &6STR: &b$line["power"]]" . "\n"));
            $count++;
        }
        return $return;
    }

    public function getTitle() : string{
        return $this->colourise($this->config["title"]);
    }

    /**
     * @return FloatingText[]
     */
    public function getParticles() : array{
        return $this->particles;
    }

    /**
     * @param string $msg
     *
     * @return string
     */
    public function colourise(string $msg) : string{
        $colour = array("{BLACK}","{DARK_BLUE}","{DARK_GREEN}","{DARK_AQUA}","{DARK_RED}","{DARK_PURPLE}","{GOLD}","{GRAY}","{DARK_GRAY}","{BLUE}","{GREEN}","{AQUA}","{RED}","{LIGHT_PURPLE}","{YELLOW}","{WHITE}","{OBFUSCATED}","{BOLD}","{STRIKETHROUGH}","{UNDERLINE}","{ITALIC}","{RESET}");
        $keys = array(C::BLACK, C::DARK_BLUE, C::DARK_GREEN, C::DARK_AQUA, C::DARK_RED, C::DARK_PURPLE, C::GOLD, C::GRAY, C::DARK_GRAY, C::BLUE, C::GREEN, C::AQUA, C::RED, C::LIGHT_PURPLE, C::YELLOW, C::WHITE, C::OBFUSCATED, C::BOLD, C::STRIKETHROUGH, C::UNDERLINE, C::ITALIC, C::RESET);
        return str_replace(
            $colour,
            $keys,
            $msg
        );
    }
}
