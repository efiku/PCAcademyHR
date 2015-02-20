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


$a[0] = $counter->getDataBetween($tablica_dat[0][0], $tablica_dat[0][1]);

echo $twig->render('header.twig');

echo $twig->render('zadanie_1.twig', array(
    'PA' => join(' do ', $tablica_dat[0]),
    'TABA' => print_r($a[0], true),
));


echo $twig->render('zadanie_2.twig', array(
    'PA' => '2014-01-08 do 2014-01-15',
    'TABA' => print_r($counter->getAverageScores($a[0], array('2014-01-08', '2014-02-03')), true)

));

echo $twig->render('fotter.twig');