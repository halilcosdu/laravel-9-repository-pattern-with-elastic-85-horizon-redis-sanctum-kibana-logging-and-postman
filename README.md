## Docker Installation

### Windows
    docker run --rm  -u "$(id -u):$(id -g)"  -v "$(pwd):/var/www/html"  -w "/var/www/html" laravelsail/php81-composer:latest  composer install --ignore-platform-reqs

### Mac & Linux
    docker run --rm \
        -u "$(id -u):$(id -g)" \
        -v $(pwd):/var/www/html \
        -w /var/www/html \
        laravelsail/php81-composer:latest \
        composer install --ignore-platform-reqs

### Setup Project
Copy .env.example file to .env file

    cp .env.example .env

### Install Docker Containers
    vendor/bin/sail up -d

#### Automated Installation

This will ask you some questions without --force parameters. It also will remove all your data.

    vendor/bin/sail artisan app:install

#### Manual Installation

*Seed All Databases*

    vendor/bin/sail artisan db:seed

### About Elasticsearch
Elasticsearch Configuration must allow using wildcards with delete indices requests

Open config with:

    sudo nano /etc/elasticsearch/elasticsearch.yml

then Set

    action.destructive_requires_name

to `false`.


By default, this parameter does not support wildcards (*) or _all. To use wildcards or _all, set the action.destructive_requires_name cluster setting to false.

You can put this setting to cluster with

    PUT /_cluster/settings
    {
        "persistent" : {
            "action.destructive_requires_name" : null
        }
    }

## RUNNING TESTS

*Running All Tests*

    vendor/bin/sail artisan test --stop-on-failure

*Running Single Test File*

    vendor/bin/sail artisan test path/to/test/file.php

*Running Single Test*

    vendor/bin/sail artisan test --filter testName path/to/test/file.php

*Delete all docker images and volumes*

    docker system prune -a --volumes
