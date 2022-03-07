<?php

    require_once __DIR__."/kernel/ClassAutoLoader.php";
    $autoLoader = new ClassAutoLoader();
    $autoLoader->setDirs(__DIR__.'/kernel');
    $autoLoader->setDirs(__DIR__.'/app/models');

?>