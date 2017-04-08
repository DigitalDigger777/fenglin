#!/usr/bin/env bash

chown -R www-data:www-data web/
chown -R www-data:www-data var/logs/
chown -R www-data:www-data var/cache/
chown -R www-data:www-data var/sessions/
chown -R korman:korman src/
