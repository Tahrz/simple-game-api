#!/usr/bin/env bash

echo '***';
echo 'generating monsters (mongodb)';
echo '===';
source $(dirname $0)/monster_generator.sh
generate_monsters

echo '***';
echo 'generating players (mongodb)';
echo '===';
source $(dirname $0)/player_generator.sh
generate_players