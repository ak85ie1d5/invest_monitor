#!/bin/bash

cd ${SYMFONY_ROOT} || exit

echo "Watching assets directory for changes..."

# boucle d'attente d'événements (création/modification/suppression/move)
while inotifywait -qq -e create,modify,delete,move -r assets; do
  php bin/console asset-map:compile
done

exec "$@"