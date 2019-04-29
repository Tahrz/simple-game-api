#!/usr/bin/env bash

monster_count=200;

function generate_monsters {
    for ((m=1; m<=monster_count; m++ ))
    do
        psql -U postgres postgres -c "INSERT INTO monsters (id, name, health) VALUES (substr(md5(random()::text), 0, 25), substr(md5(random()::text), 0, 10), random()*(99-1)+1)" >&-
    done
}