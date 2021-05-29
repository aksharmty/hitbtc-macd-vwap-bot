<?php
include "connect.php";
//macd
$macdf = mysqli_fetch_assoc(mysqli_query($connection,"select avg(macd) as mas from macd order by date desc limit 9"));
$msig = number_format($macdf['mas'],11,".",""); echo "<br>  msig ".$msig; 
$ma12=number_format($ma120['ma121'],11,".",""); echo " <br>Ma12 ".$ma12;

$ma120 = mysqli_fetch_assoc(mysqli_query($connection,"select avg(close) as ma121 from candle where id between 1 AND 12"));
$ma12=number_format($ma120['ma121'],11,".",""); echo " <br>Ma12 ".$ma12;

$ma260 = mysqli_fetch_assoc(mysqli_query($connection,"select avg(close) as ma261 from candle where id between 1 AND 26"));
$ma26 = number_format($ma260['ma261'],11,".",""); echo "<br> ma26 ".$ma26;
$macd = number_format($ma12-$ma26,11,".",""); echo "<br> macd " .$macd;

$macdc = mysqli_fetch_assoc(mysqli_query($connection,"select * from macd order by date desc limit 1"));
$count = $macdc['count']+1; echo "<br>  count ".$count;
$macdup = mysqli_query($connection,"update macd set count ='$count' order by date desc limit 1");
if($count > 4){
$macdin = mysqli_query($connection,"INSERT INTO macd(pair,macd,date,count) VALUES ('$pair','$macd','$date','0'); ");
}
$macdc = mysqli_fetch_assoc(mysqli_query($connection,"select count(macd) as mac from macd where pair = '$pair'"));
$mcount = $macdc['mac']; echo "<br>  mcount ".$mcount; 
if($mcount > "9"){$macd10 = mysqli_fetch_array(mysqli_query($connection,"SELECT * FROM macd order by date asc limit 1"));
echo "<br> macd date ". $macd10['date'];
$macddel = mysqli_query($connection,"delete from macd where date = '$macd10[date]'"); } else {echo " mcount less then 9 ";}

?>
