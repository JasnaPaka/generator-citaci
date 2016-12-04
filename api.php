<?php

require __DIR__ . '/vendor/autoload.php';

include_once __DIR__ . "/config.php";
include_once __DIR__ . "/src/JasnaPaka/Citation/CitationController.php";

use JasnaPaka\Citation\CitationController;

$controller = new CitationController();
$controller->process();

