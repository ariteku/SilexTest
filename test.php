<?php

require "Pager.php";

$pager = new Pager();

$page = $pager->getPager(50,2);

print_r($page);
