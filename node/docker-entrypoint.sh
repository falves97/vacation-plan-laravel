#!/bin/sh
set -e

if [ "$1" = 'yarn' ]; then

  if [ -z "$(ls -A 'node_modules/' 2>/dev/null)" ]; then
      yarn
  fi

fi

exec "$@"