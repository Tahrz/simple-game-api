#!/usr/bin/env bash

monster_count=200;

function generate_monsters {
    for ((m=1; m<=monster_count; m++ ))
    do
        mongo --eval "db.getSiblingDB('game').monsters.insert({name: (Math.random()+1).toString(24).substring(2), health: NumberInt(Math.floor(Math.random() * (100 - 1 + 1)) + 1)})" >&-
    done
}