#!/usr/bin/env bash

set -e

role=${CONTAINER_ROLE:-app}
env=${APP_ENV:-production}

if [ "$env" != "local" ]; then
    echo "Caching configuration..."
#    (cd /srv && php artisan config:cache && php artisan route:cache && php artisan view:cache)
fi

if [ "$role" = "app" ]; then

    exec ls

elif [ "$role" = "queue" ]; then

    echo "Queue role"
    exec php /srv/artisan queue:work
    exit 1

elif [ "$role" = "scheduler" ]; then

    while [ true ]
    do
      php /srv/artisan schedule:run --verbose --no-interaction &
      sleep 60
    done

else
    echo "Could not match the container role \"$role\""
    exit 1
fi
