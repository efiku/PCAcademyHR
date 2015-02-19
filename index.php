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

$loader = new Twig_Loader_Filesystem('./templates/');
$twig = new Twig_Environment($loader);


$tablica_dat[0] = Array('2014-01-15', '2014-02-22');
$tablica_dat[1] = Array('2014-03-03', '2014-05-11');
$tablica_dat[2] = Array('2015-06-15', '2015-08-15');


$a[0] = $counter->getDataBetween($tablica_dat[0][0], $tablica_dat[0][1]);
$a[1] = $counter->getDataBetween($tablica_dat[1][0], $tablica_dat[1][1]);
$a[2] = $counter->getDataBetween($tablica_dat[2][0], $tablica_dat[2][1]);

echo $twig->render('header.twig');

echo $twig->render('zadanie_1.twig', array(
    'PA' => join(' do ', $tablica_dat[0]),
    'PB' => join(' do ', $tablica_dat[1]),
    'PC' => join(' do ', $tablica_dat[2]),
    'TABA' => print_r($a[0], true),
    'TABB' => print_r($a[1], true),
    'TABC' => print_r($a[2], true)
));


echo $twig->render('zadanie_2.twig', array(
    'PA' => '2014-01-08 do 2014-01-15',
    'PB' => '2014-03-04 do 2014-05-03',
    'PC' => '2014-05-16 do 2014-06-11',
    'TABA' => print_r($counter->getbet($a[0], '2014-01-08', '2014-01-15'), true),
    'TABB' => print_r($counter->getbet($a[1], '2014-03-04', '2014-05-03'), true),
    'TABC' => print_r($counter->getbet($a[2], '2014-05-16', '2014-06-11'), true)
));

echo $twig->render('fotter.twig');