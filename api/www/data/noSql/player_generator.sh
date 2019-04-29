#!/usr/bin/env bash

player_count=1500;

function generate_players {
    for ((p=1; p<=player_count; p++ ))
    do
        mongo --eval "db.getSiblingDB('game').players.insert({username: (Math.random()+1).toString(24).substring(2), health: NumberInt(Math.floor(Math.random() * (100 - 1 + 1)) + 1)})" >&-
    done
}