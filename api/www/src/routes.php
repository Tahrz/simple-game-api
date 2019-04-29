<?php

use Pecee\SimpleRouter\SimpleRouter;
use Application\Action\PlayerListAction;
use Application\Action\MonsterListAction;
use Application\Action\OpenMonsterAction;
use Application\Action\ShowOpenedMonstersAction;

SimpleRouter::get('/monster/list', MonsterListAction::class);

SimpleRouter::get('/player/list', PlayerListAction::class);
SimpleRouter::get('/player/open-monster', OpenMonsterAction::class);
SimpleRouter::get('/player/show-opened-monsters', ShowOpenedMonstersAction::class);