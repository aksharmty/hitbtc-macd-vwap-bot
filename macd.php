<?php
//macd calculation 
// MACD Line: (12-day EMA - 26-day EMA) 
// Signal Line: 9-day EMA of MACD Line MACD 
// Histogram: MACD Line - Signal Line

include "connect.php";
// ma cross
//12ma
$ma12a0 = mysqli_fetch_assoc(mysqli_query($connection,"SELECT AVG(close) AS ma12a1 FROM candle where id BETWEEN 1 AND 12"));
$ma12a2 = $ma12a0['ma12a1']; $ma12a =number_format($ma12a2,11,".","");

$ma12b0 = mysqli_fetch_assoc(mysqli_query($connection,"SELECT AVG(close) AS ma12b1 FROM candle where id BETWEEN 2 AND 13"));
$ma12b2 = $ma12b0['ma12b1']; $ma12b =number_format($ma12b2,11,".","");

$ma12c0 = mysqli_fetch_assoc(mysqli_query($connection,"SELECT AVG(close) AS ma12c1 FROM candle where id BETWEEN 3 AND 14"));
$ma12c2 = $ma12c0['ma12c1']; $ma12c =number_format($ma12c2,11,".","");

$ma12d0 = mysqli_fetch_assoc(mysqli_query($connection,"SELECT AVG(close) AS ma12d1 FROM candle where id BETWEEN 4 AND 15"));
$ma12d2 = $ma12d0['ma12d1']; $ma12d =number_format($ma12d2,11,".","");

$ma12e0 = mysqli_fetch_assoc(mysqli_query($connection,"SELECT AVG(close) AS ma12e1 FROM candle where id BETWEEN 5 AND 16"));
$ma12e2 = $ma12e0['ma12e1']; $ma12e =number_format($ma12e2,11,".","");

$ma12f0 = mysqli_fetch_assoc(mysqli_query($connection,"SELECT AVG(close) AS ma12f1 FROM candle where id BETWEEN 6 AND 17"));
$ma12f2 = $ma12f0['ma12f1']; $ma12f =number_format($ma12f2,11,".","");

$ma12g0 = mysqli_fetch_assoc(mysqli_query($connection,"SELECT AVG(close) AS ma12g1 FROM candle where id BETWEEN 7 AND 18"));
$ma12g2 = $ma12g0['ma12g1']; $ma12g =number_format($ma12g2,11,".","");

$ma12h0 = mysqli_fetch_assoc(mysqli_query($connection,"SELECT AVG(close) AS ma12h1 FROM candle where id BETWEEN 8 AND 19"));
$ma12h2 = $ma12h0['ma12h1']; $ma12h =number_format($ma12h2,11,".","");

$ma12i0 = mysqli_fetch_assoc(mysqli_query($connection,"SELECT AVG(close) AS ma12i1 FROM candle where id BETWEEN 9 AND 20"));
$ma12i2 = $ma12i0['ma12i1']; $ma12i =number_format($ma12i2,11,".","");


//26ma
$ma26a0 = mysqli_fetch_assoc(mysqli_query($connection,"SELECT AVG(close) AS ma26a1 FROM candle where id BETWEEN 1 AND 26"));
$ma26a2 = $ma26a0['ma26a1']; $ma26a =number_format($ma26a2,11,".","");

$ma26b0 = mysqli_fetch_assoc(mysqli_query($connection,"SELECT AVG(close) AS ma26b1 FROM candle where id BETWEEN 2 AND 27"));
$ma26b2 = $ma26b0['ma26b1']; $ma26b =number_format($ma26b2,11,".","");

$ma26c0 = mysqli_fetch_assoc(mysqli_query($connection,"SELECT AVG(close) AS ma26c1 FROM candle where id BETWEEN 3 AND 28"));
$ma262 = $ma26c0['ma26c1']; $ma26c =number_format($ma26c2,11,".","");

$ma26d0 = mysqli_fetch_assoc(mysqli_query($connection,"SELECT AVG(close) AS ma26d1 FROM candle where id BETWEEN 4 AND 29"));
$ma26d2 = $ma26d0['ma26d1']; $ma26d =number_format($ma26d2,11,".","");

$ma26e0 = mysqli_fetch_assoc(mysqli_query($connection,"SELECT AVG(close) AS ma26e1 FROM candle where id BETWEEN 5 AND 30"));
$ma26e2 = $ma26e0['ma26e1']; $ma26e =number_format($ma26e2,11,".","");

$ma26f0 = mysqli_fetch_assoc(mysqli_query($connection,"SELECT AVG(close) AS ma26f1 FROM candle where id BETWEEN 6 AND 31"));
$ma26f2 = $ma26f0['ma26f1']; $ma26f =number_format($ma26f2,11,".","");

$ma26g0 = mysqli_fetch_assoc(mysqli_query($connection,"SELECT AVG(close) AS ma26g1 FROM candle where id BETWEEN 7 AND 32"));
$ma26g2 = $ma26g0['ma26g1']; $ma26g =number_format($ma26g2,11,".","");

$ma26h0 = mysqli_fetch_assoc(mysqli_query($connection,"SELECT AVG(close) AS ma26h1 FROM candle where id BETWEEN 8 AND 33"));
$ma26h2 = $ma26h0['ma26h1']; $ma26h =number_format($ma26h2,11,".","");

$ma26i0 = mysqli_fetch_assoc(mysqli_query($connection,"SELECT AVG(close) AS ma26i1 FROM candle where id BETWEEN 9 AND 34"));
$ma26i2 = $ma26i0['ma26i1']; $ma26i =number_format($ma26i2,11,".","");


$macd1 = number_format($ma12a-$ma26a,11);
$macd2 = number_format($ma12b-$ma26b,11);
$macd3 = number_format($ma12c-$ma26c,11);
$macd4 = number_format($ma12d-$ma26d,11);
$macd5 = number_format($ma12e-$ma26e,11);
$macd6 = number_format($ma12f-$ma26f,11);
$macd7 = number_format($ma12g-$ma26g,11);
$macd8 = number_format($ma12h-$ma26h,11);
$macd9 = number_format($ma12i-$ma26i,11);

$macd = number_format($ma12a-$ma26a,11);
$signalline0 = $macd1+$macd2+$macd3+$macd4+$macd5+$macd6+$macd7+$macd8+$macd9);
$signalline  = number_format($signalline0/9,11);
  //MACD Histogram: MACD Line - Signal Line
$histogram = number_format($macd - $signalline,11);
?>
<!--table border="1">
<tr><th>sr.no</th><th>ma12</th><th>ma26</th><th>macd</th></tr>
<tr><td>1</td><td><?php echo $ma12a ?></td><td><?php echo $ma26a ?></td><td><?php echo $macd1 ?></td></tr>
<tr><td>2</td><td><?php echo $ma12b ?></td><td><?php echo $ma26b ?></td><td><?php echo $macd2 ?></td></tr>
<tr><td>3</td><td><?php echo $ma12c ?></td><td><?php echo $ma26c ?></td><td><?php echo $macd3 ?></td></tr>
<tr><td>4</td><td><?php echo $ma12d ?></td><td><?php echo $ma26d ?></td><td><?php echo $macd4 ?></td></tr>
<tr><td>5</td><td><?php echo $ma12e ?></td><td><?php echo $ma26e ?></td><td><?php echo $macd5 ?></td></tr>
<tr><td>6</td><td><?php echo $ma12f ?></td><td><?php echo $ma26f ?></td><td><?php echo $macd6 ?></td></tr>
<tr><td>7</td><td><?php echo $ma12g ?></td><td><?php echo $ma26g ?></td><td><?php echo $macd7 ?></td></tr>
<tr><td>8</td><td><?php echo $ma12h ?></td><td><?php echo $ma26h ?></td><td><?php echo $macd8 ?></td></tr>
<tr><td>9</td><td><?php echo $ma12i ?></td><td><?php echo $ma26i ?></td><td><?php echo $macd9 ?></td></tr></table -->
<?php
//echo " MACD ".$macd . "<br>";
//echo " Signal line ".$signalline . "<br>";
//echo " Histogram line".$histogram . "<br>";
$connection->close();
?>
