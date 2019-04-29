#!/usr/bin/env bash

monster_count=1500;

function generate_players {
    for ((p=1; p<=monster_count; p++ ))
    do
        psql -U postgres postgres -c "INSERT INTO players (id, username, health) VALUES (substr(md5(random()::text), 0, 25), substr(md5(random()::text), 0, 10), random()*(99-1)+1)" >&-
    done
}