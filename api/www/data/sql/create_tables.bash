#!/usr/bin/env bash

psql -U postgres postgres -f $(dirname $0)/create_tables.sql

echo '***';
echo 'generating monsters (postgres)';
echo '===';
source $(dirname $0)/monster_generator.sh
generate_monsters

echo '***';
echo 'generating players (postgres)';
echo '===';
source $(dirname $0)/player_generator.sh
generate_players