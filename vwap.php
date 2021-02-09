<?php
include "connect.php";

// ma cross
$ma600 = mysqli_fetch_assoc(mysqli_query($connection,"SELECT * FROM candle where id = 6"));
$ma500 = mysqli_fetch_assoc(mysqli_query($connection,"SELECT * FROM candle where id = 5"));
$ma400 = mysqli_fetch_assoc(mysqli_query($connection,"SELECT * FROM candle where id = 4"));
$ma300 = mysqli_fetch_assoc(mysqli_query($connection,"SELECT * FROM candle where id = 3"));
$ma200 = mysqli_fetch_assoc(mysqli_query($connection,"SELECT * FROM candle where id = 2"));
$ma100 = mysqli_fetch_assoc(mysqli_query($connection,"SELECT * FROM candle where id = 1"));

$tp06=number_format($ma600['close']+$ma600['max']+$ma600['min'],11);
$tp6 = number_format($tp06/3,11);

$tp05=number_format($ma500['close']+$ma500['max']+$ma500['min'],11);
$tp5 = number_format($tp05/3,11);

$tp04=number_format($ma400['close']+$ma400['max']+$ma400['min'],11);
$tp4 = number_format($tp04/3,11);

$tp03=number_format($ma300['close']+$ma300['max']+$ma300['min'],11);
$tp3 = number_format($tp03/3,11);

$tp02=number_format($ma200['close']+$ma200['max']+$ma200['min'],11); 
$tp2 = number_format($tp02/3,11);

$tp01=number_format($ma100['close']+$ma100['max']+$ma100['min'],11);
$tp1 = number_format($tp01/3,11);

//tp*v
$tpv6 = $tp6*$ma600['volume'];
$tpv5 = $tp5*$ma500['volume'];
$tpv4 = $tp4*$ma400['volume'];
$tpv3 = $tp3*$ma300['volume'];
$tpv2 = $tp2*$ma200['volume'];
$tpv1 = $tp1*$ma100['volume'];

//tp*v+
$tpvp6 = $tpv6;
$tpvp5 = $tpvp6+$tpv5;
$tpvp4 = $tpvp5+$tpv4;
$tpvp3 = $tpvp4+$tpv3;
$tpvp2 = $tpvp3+$tpv2;
$tpvp1 = $tpvp2+$tpv1;


//volume+
$vol6 = $ma600['volume'];
$vol5 = $vol6+$ma500['volume']; 
$vol4 = $vol5+$ma400['volume'];
$vol3 = $vol4+$ma300['volume'];
$vol2 = $vol3+$ma200['volume'];
$vol1 = $vol2+$ma100['volume'];


$vwap6 = number_format($tpvp6/$vol6,10);
$vwap5 = number_format($tpvp5/$vol5,10);
$vwap4 = number_format($tpvp4/$vol4,10);
$vwap3 = number_format($tpvp3/$vol3,10);
$vwap2 = number_format($tpvp2/$vol2,10);
$vwap1 = number_format($tpvp1/$vol1,10);
$connection->close();
?>
