<?php
include "connect.php";

// ma cross
$ma500 = mysqli_fetch_assoc(mysqli_query($connection,"SELECT * FROM candle where id = 5"));
$ma400 = mysqli_fetch_assoc(mysqli_query($connection,"SELECT * FROM candle where id = 4"));
$ma300 = mysqli_fetch_assoc(mysqli_query($connection,"SELECT * FROM candle where id = 3"));
$ma200 = mysqli_fetch_assoc(mysqli_query($connection,"SELECT * FROM candle where id = 2"));
$ma100 = mysqli_fetch_assoc(mysqli_query($connection,"SELECT * FROM candle where id = 1"));

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
$tpv5 = $tp5*$ma500['volume'];
$tpv4 = $tp4*$ma400['volume'];
$tpv3 = $tp3*$ma300['volume'];
$tpv2 = $tp2*$ma200['volume'];
$tpv1 = $tp1*$ma100['volume'];

//tp*v+
$tpvp5 = $tpv5;
$tpvp4 = $tpvp5+$tpv4;
$tpvp3 = $tpvp4+$tpv3;
$tpvp2 = $tpvp3+$tpv2;
$tpvp1 = $tpvp2+$tpv1;

//volume+
$nvol5 = $ma500['volume']; 
$nvol4 = $nvol5+$ma400['volume'];
$nvol3 = $nvol4+$ma300['volume'];
$nvol2 = $nvol3+$ma200['volume'];
$nvol1 = $nvol2+$ma100['volume'];

$vwap5 = number_format($tpvp5/$nvol5,11);
$vwap4 = number_format($tpvp4/$nvol4,11);
$vwap3 = number_format($tpvp3/$nvol3,11);
$vwap2 = number_format($tpvp2/$nvol2,11);
$vwap1 = number_format($tpvp1/$nvol1,11);
$connection->close();
?>
