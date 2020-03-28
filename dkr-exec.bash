#!/usr/bin/env bash

#export uid=$(id -u):$(id -g)
export uid=1000:1000

case $1 in
  "run")
    docker-compose up -d
    ;;
  "recreate")
    docker-compose build --no-cache && docker-compose up -d
    ;;
  "stop")
    docker-compose stop
    ;;
  "ssh")
    docker-compose exec ${2} /bin/bash
    ;;
  "tinker")
    docker-compose exec app /bin/bash -c "php artisan tinker"
    ;;
  "artisan")
    docker-compose exec app /bin/bash -c "(php artisan ${*:2})"
    ;;
  "sc-dusk")
    docker-compose exec app /bin/bash -c "(php artisan dusk --env=scormcloud --configuration phpunit.dusk.scormcloud.xml ${*:2})"
    ;;
  "composer")
    docker-compose exec app /bin/bash -c "(composer ${*:2})"
    ;;
  "phpunit")
    docker-compose exec app /bin/bash -c "(vendor/bin/phpunit ${*:2})"
    ;;
  "codestyle")
    docker-compose exec app /bin/bash -c "(vendor/bin/phpcs --standard=PSR2 --extensions=php app)"
  ;;
  "npm")
    docker-compose run --rm node /bin/bash -c "(npm ${*:2})"
    ;;
  *)
    echo -e "\e[33mArguments:\e[32m";
    echo -e "     run";
    echo -e "     recreate";
    echo -e "     stop";
    echo -e "     ssh SERVICE";
    echo -e "     artisan COMMAND";
    echo -e "     sc-dusk OPTIONS";
    echo -e "     composer COMMAND";
    echo -e "     phpunit";
    echo -e "     npm COMMAND";
    echo -e "\e[39m"
    exit 1;
    ;;
esac