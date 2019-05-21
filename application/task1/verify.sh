#!/bin/bash

set -e

composer install -q

echo "# TESTS #"
vendor/bin/phpunit || true

echo "# CODE SNIFFER #"
vendor/bin/phpcs --standard=PSR2 -p src tests || true
