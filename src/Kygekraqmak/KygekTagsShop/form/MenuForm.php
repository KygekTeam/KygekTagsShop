<?php

/*
 *  PLUGIN BY:
 *   _    __                  _                                     _
 *  | |  / /                 | |                                   | |
 *  | | / /                  | |                                   | |
 *  | |/ / _   _  ____   ____| | ______ ____   _____ ______   ____ | | __
 *  | |\ \| | | |/ __ \ / __ \ |/ /  __/ __ \ / __  | _  _ \ / __ \| |/ /
 *  | | \ \ \_| | <__> |  ___/   <| / | <__> | <__| | |\ |\ | <__> |   <
 *  |_|  \_\__  |\___  |\____|_|\_\_|  \____^_\___  |_||_||_|\____^_\|\_\
 *            | |    | |                          | |
 *         ___/ | ___/ |                          | |
 *        |____/ |____/                           |_|
 *
 * A PocketMine-MP plugin to buy tags with money
 * Copyright (C) 2020 Kygekraqmak
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 */

declare(strict_types=1);

namespace Kygekraqmak\KygekTagsShop\form;

use Kygekraqmak\KygekTagsShop\TagsShop;
use Kygekraqmak\KygekTagsShop\utils\Replace;
use jojoe77777\FormAPI\SimpleForm;
use pocketmine\Player;

class MenuForm {

    protected static function getMain() : TagsShop {
        return TagsShop::getPlugin();
    }

    public static function menuForm(Player $player) {
        $form = new SimpleForm(function (Player $player, int $data = null) {
            if ($data === null) return true;
            switch ($data) {
                case 0:
                    BuyForm::tagsListForm($player);
                    break;
                case 1:
                    $tagid = self::getMain()->getAPI()->getPlayerTag($player);
                    if ($tagid === null) {
                        SellForm::noTagForm($player);
                    } else {
                        SellForm::sellTagForm($player, $tagid);
                    }
                    break;
            }
        });

        $form->setTitle(Replace::replaceGeneric($player, self::getMain()->config["main-title"]));
        $form->setContent(Replace::replaceGeneric($player, self::getMain()->config["main-content"]));
        $form->addButton(Replace::replaceGeneric($player, self::getMain()->config["main-buy-button"]));
        $form->addButton(Replace::replaceGeneric($player, self::getMain()->config["main-sell-button"]));
        $form->addButton(Replace::replaceGeneric($player, self::getMain()->config["main-exit-button"]));
        $player->sendForm($form);
     }

}