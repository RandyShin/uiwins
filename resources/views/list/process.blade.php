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

$balance = $deposits_total - $total;
echo '<br>';
echo 'balance is ' . $balance;


$ch = curl_init();

if
($balance <= 0 ) {
    curl_setopt($ch, CURLOPT_URL, "http://pbx01.ziotes.com:5833/smi_deposit_down.php");
    curl_exec($ch);
}

