<?php
/**
 * Created by PhpStorm.
 * User: randy
 * Date: 2017-11-08
 * Time: 오후 9:51
 */



echo "deposit total is " . $deposits_total;
echo '<br>';
echo "total is " . $total ;

$balacnce = $deposits_total - $total;
echo '<br>';
echo 'balance is ' . $balacnce;

if ($balacnce <= 0) {
    echo "wala";
}