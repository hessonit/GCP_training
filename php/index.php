<?php

$name = getenv('NAME', true) ?: 'World';
echo sprintf('Hello %s!', $name);

$otherName = getenv('DB_NAME', true) ?: 'UNKNOWN';
echo sprintf('Hello %s!', $otherName);