#!/usr/bin/env bash

#********************************************************************
#   Simplest bash ever been...
#********************************************************************

echo '==='
echo 'Building'
docker-compose build
echo '***'
echo 'Starting'
docker-compose up -d

#********************************************************************
#   Composer-install && Tests run (only two, yep =])
#********************************************************************

docker exec -it heatherglade_test_task_php_cli bash -c "composer install"
docker exec -it heatherglade_test_task_php_cli vendor/bin/phpunit --bootstrap vendor/autoload.php tests

#********************************************************************
#   Data generation
#********************************************************************

read -n 1 -p "Generate Players and Monsters? " AMSURE
[ "$AMSURE" = "y" ] || exit
echo "" 1>&2

START=$(date +%s)
docker exec -it heatherglade_test_task_postgre /data/./create_tables.bash
END=$(date +%s)
echo "-> It took $(( $END - $START )) seconds"

#********************************************************************

echo "" 1>&2

#********************************************************************

START=$(date +%s)
docker exec -it heatherglade_test_task_mongo /data/./create_collections.sh
END=$(date +%s)
echo "-> It took $(( $END - $START )) seconds"