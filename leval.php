<?php
include "connect.php"; 

$sql1 = mysqli_fetch_array(mysqli_query($connection,"SELECT * FROM tradebtc where type = '0' order by id desc limit 1"));
$id1 = $sql1["id"]; $price1 = $sql1["price"]*$sql1["quantity"]; $quantity1 = $sql1["quantity"];

$sql2 = mysqli_fetch_array(mysqli_query($connection,"SELECT * FROM tradebtc where type = '0' AND id < '$id1' order by id desc limit 1"));
$id2 = $sql2["id"]; $price2 = $sql2["price"]*$sql2["quantity"]; $quantity2 = $sql2["quantity"];

$sql3 = mysqli_fetch_array(mysqli_query($connection,"SELECT * FROM tradebtc where type = '0' AND id < '$id2' order by id desc limit 1"));
$id3 = $sql3["id"]; $price3 = $sql3["price"]*$sql3["quantity"]; $quantity3 = $sql3["quantity"];

$sql4 = mysqli_fetch_array(mysqli_query($connection,"SELECT * FROM tradebtc where type = '0' AND id < '$id3' order by id desc limit 1"));
$id4 = $sql4["id"]; $price4 = $sql4["price"]*$sql4["quantity"]; $quantity4 = $sql4["quantity"];

$sql5 = mysqli_fetch_array(mysqli_query($connection,"SELECT * FROM tradebtc where type = '0' AND id < '$id4' order by id desc limit 1"));
$id5 = $sql5["id"]; $price5 = $sql5["price"]*$sql5["quantity"]; $quantity5 = $sql5["quantity"];

$quantityt = $quantity1+$quantity2+$quantity3+$quantity4+$quantity5;
$pricet = $price1+$price2+$price3+$price4+$price5;

$sqlcount = mysqli_fetch_array(mysqli_query($connection,"SELECT COUNT(id) AS coco FROM tradebtc where type = '0'"));
$countt = $sqlcount['coco'];
if($countt > 0){
$newprice = number_format($pricet/$quantityt,11);
$takeprofit0 = $newprice+$newprice*0.25/100;
$takeprofit = number_format($takeprofit0,11,".", "");
}
//echo "<br> id " .$id1 . " price " . $price1 . " quantity " . $quantity1;
//echo "<br> id " .$id2 . " price " . $price2 . " quantity " . $quantity2;
//echo "<br> id " .$id3 . " price " . $price3 . " quantity " . $quantity3;
//echo "<br> id " .$id4 . " price " . $price4 . " quantity " . $quantity4;
//echo "<br> id " .$id5 . " price " . $price5 . " quantity " . $quantity5;
//echo "<br> quantityt ".$quantityt;
//echo "<br> pricet ".$pricet;
//echo "<br> new price ". $newprice;
//echo "<br> countt ".$countt;
?>
