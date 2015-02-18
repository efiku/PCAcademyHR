<?php
/**
 * Created by PhpStorm.
 * User: Krzysztof
 * Date: 2015-02-17
 */

    require_once('config.php');
    require('./classes/Counter.php');
    require('./vendor/autoload.php');

   use PCAcademyHR\Counter;

    $counter = Counter::getInstance($config);
    unset($config);

    $a = $counter->getDataBetween("2014-01-15", "2014-02-15");
       print_r($a);

