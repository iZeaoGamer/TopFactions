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

use pocketmine\level\particle\FloatingTextParticle;
use pocketmine\math\Vector3;

class FloatingText extends FloatingTextParticle {
    private $plugin;
    private $level;
    private $position;

    public function __construct(Main $plugin, Vector3 $position)
    {
        parent::__construct($position, "", "");
        $this->plugin = $plugin;
        $this->level = $this->plugin->getServer()->getDefaultLevel();
        $this->position = $position;
    }

    public function setText(string $text, bool $update = true) : void{
        $this->text = $text;
        if($update) $this->update();
    }

    public function setTitle(string $title, bool $update = true) : void{
        $this->title = $title;
        if($update) $this->update();
    }

    public function setInvisible(bool $value = true, bool $update = true) : void{
        $this->invisible = $value;
        if($update) $this->update();
    }

    public function update() : void{
        $this->level->addParticle($this);
    }
}