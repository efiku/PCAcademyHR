<?php
/**
 * Created by PhpStorm.
 * User: Krzysztof
 * Date: 2015-02-17
 */

    require_once('config.php');
    require('./classes/Counter.php');


   use efikCounter\Counter;

    $counter = Counter::getInstance($config);
    unset($config);



