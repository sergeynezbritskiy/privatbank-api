#!/usr/bin/env bash
./vendor/bin/phpcs --standard="./vendor/squizlabs/php_codesniffer/src/Standards/PSR12/ruleset.xml" ./src
./vendor/bin/phpunit
