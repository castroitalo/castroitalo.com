<?php

declare(strict_types=1);

use Castroitalo\Core\Database\Connection;

require_once __DIR__ . '/bootstrap.php';

var_dump(Connection::isConnected());
