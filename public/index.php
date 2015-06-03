<?php

require_once '../vendor/autoload.php';
require_once '../setup.php';

// Include our controllers
require_once '../controller/news.php';
require_once '../controller/feed.php';
require_once '../controller/tag.php';
require_once '../controller/admin.php';
require_once '../controller/index.php';

$app->run();