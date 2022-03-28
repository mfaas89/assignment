<?php

require_once('../Core/AutoLoader.php');

use Core\AutoLoader;

$autoloader = new AutoLoader();
$autoloader->register();

use Core\App;

$app = new App();
