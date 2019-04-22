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

use pocketmine\scheduler\Task;

class UpdateTask extends Task{
    private $plugin;

    /**
     * Gametimer constructor.
     * @param Main $plugin
     */
    public function __construct(Main $plugin){
        $this->plugin = $plugin;
    }

    /**
     * @param int $currentTick
     */
    public function onRun(int $currentTick)
    {
        $title = $this->plugin->getTitle();
        $lb = $this->plugin->getLeaderBoard();
        $list = $this->plugin->getParticles();
        foreach($list as $particle){
            $particle->setTitle($title, false);
            $particle->setText($lb);
        }
    }
}