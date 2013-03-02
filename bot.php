#!/usr/bin/env php
<?php

ini_set('display_errors','stdout');
error_reporting(E_ALL ^ E_NOTICE);
date_default_timezone_set('America/New_York');

require('brobot.php');

$brobot = new \Brobot\Brobot($argv[1]);
$brobot->go();

?>
