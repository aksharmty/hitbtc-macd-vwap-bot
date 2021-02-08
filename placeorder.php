<?php
include "0macd.php";
include "0vwap.php";
echo " MACD ".$macd . "<br>";
echo " Signal line ".$signalline . "<br>";
echo " Histogram ".$histogram . "<br>";
echo " VWAP ". $vwap1 . "<br>";

define('TIMEZONE', 'Asia/kolkata');
date_default_timezone_set(TIMEZONE);
  $date = DATE("Y-m-d H:i:s");
  $keyapi = 'API_KEY:SECRET_KEY'; //wrtite your api key
$balurl = 'https://api.hitbtc.com/api/2/trading/balance';
$orderurl = 'https://api.hitbtc.com/api/2/order';

//  $coinsql = mysqli_fetch_array(mysqli_query($connection,"SELECT * FROM coin where coin ='DOGE' AND market = 'BTC'"));// order by RAND() limit 1"));
$coin = "DOGE";//$coinsql['coin'];
$market = "BTC";//$coinsql['market'];
//$quantity = $coinsql['quantity'];
$pair = $coin.$market;
echo "pair : ",$pair; 
          
$sql123 = mysqli_query($connection,"TRUNCATE TABLE candle");
$json = "https://api.hitbtc.com/api/2/public/candles/DOGEBTC?period=M30&sort=DESC&limit=50"; //getting the file content for candle
          $query = '';
  $data = file_get_contents($json); //Read the JSON file in PHP
  $array = json_decode($data, true); //Convert JSON String into PHP Array
  foreach($array as $row) //Extract the Array Values by using Foreach Loop
          {
  $query .= mysqli_query($connection,"INSERT INTO candle(open,close,volume) VALUES ('".$row["open"]."','".$row["close"]."','".$row["volume"]."'); "); 
          }
?>
<?php 
//market bal
 $chbal = curl_init($balurl); 
 curl_setopt($chbal, CURLOPT_USERPWD, $keyapi); // API AND KEY
 curl_setopt($chbal, CURLOPT_RETURNTRANSFER,1);
 curl_setopt($chbal, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
curl_setopt($chbal, CURLOPT_HTTPHEADER, array('accept: application/json'));
 $return = curl_exec($chbal); 
  curl_close($chbal); 
 //print_r($return);
$data = json_decode($return, true);
$need = array(  //1 =>'DOGE',
    $market
);
foreach ($data as $key => $value) {//Extract the Array Values by using Foreach Loop
          if (in_array($data[$key]['currency'], $need)) {
              $marketbalance=$data[$key]['available'];
          }}
echo "market bal : ", $market . ':' . $marketbalance;
 //coin bal 
$need0 = array(    //1 =>'DOGE',
    $coin
);
foreach ($data as $key => $value) {
          if (in_array($data[$key]['currency'], $need0)) {
              $coinbalance=$data[$key]['available'];
              $reserved = $data[$key]['reserved'];
          }}
          echo "coin bal : ",$coin . ':' . $coinbalance;
?>
<?php
//ask - bid check
$url = "https://api.hitbtc.com/api/2/public/ticker/$pair";
$dataDOGEBTC = json_decode(file_get_contents($url), true);
$bid=$dataDOGEBTC['bid'];   $ask = $dataDOGEBTC['ask']; 
$close30 = mysqli_fetch_array(mysqli_query($connection," select * from candle where id ='3'")); 
$close3 =$close30['close'];
$lastclose0 = mysqli_fetch_array(mysqli_query($connection,"select * from candle where id ='2'"));
$lastclose = $lastclose0['close'];
$cuopen0 = mysqli_fetch_array(mysqli_query($connection,"select * from candle where id = 1"));
$cuopen = $cuopen0['open']; echo "<br>cuopen ".$cuopen; echo "<br>LASTCLOSE : ", $lastclose ."<br>";

echo "ASK : ", $ask . " BID " . $bid ."<br>";

?>
<?php //last trade details
$askup0 = mysqli_fetch_array(mysqli_query($connection,"select * from tradebtc order by id desc limit 1"));
$idu = $askup0['id']; echo "<br>idu :" , $idu;
$hma = $askup0['hma']; echo "<br>hma :" , $hma;
$hmas = $askup0['hmas']; echo "<br>hmas :". $hmas;
$typ = $askup0['type']; $prequantity = $askup0['quantity']*2;
$dlastbal = $askup0['dlastbal']; echo "<br>dlastbal :" , $dlastbal;
$lastbal = $askup0['lastbal']; echo "<br>lastbal :" , $lastbal;
$lastprice = $askup0['sellprice'];
$waitprice = number_format($lastprice-$lastprice*5/100,11);echo "wait price ".$waitprice;
$mp1 = $marketbalance-$marketbalance*90.715/100;//93.333/100;
echo "<br>mp1 ".$mp1;
$qq0 = $mp1/$ask/"1"; //$qq0 = $marketbalance/$ask/"10"; 
$quantityr=floor($qq0/10)*10; 
if($typ == "0"){$quantity = $prequantity;}else{$quantity = $quantityr;}
echo "<br> Qq", $quantity; $quantityd=$quantity*2; 
$coinbalance1=floor($coinbalance/10)*10;

?>
<?php
//vol and quantity
$jsondata0 = file_get_contents("https://api.hitbtc.com/api/2/public/orderbook/DOGEBTC?volume=$quantityd");
$data0 = json_decode($jsondata0, true);
$array_ask = $data0['ask'];
foreach ($array_ask as $row) { $ask0 = $row["price"];}
$ask1 = number_format($ask0,11);
echo "<br>Buy price : ". $ask1 ."<br>";
$buy = $ask1;
$sell0 = $buy+$buy*0.25/100; 
$sellprice = number_format($sell0,11, ".", ""); echo "<br>sellprice :",$sellprice;
$btcl = $quantity*$buy; $btclow = number_format($btcl,11);
echo "<br>btc low :",$btclow;
?>
<?php //average price start
$sql2021 = "SELECT * FROM tradebtc where type ='0'";
$result2021 = $connection->query($sql2021);

if ($result2021->num_rows > 0) {
  // output data of each row
  while($row2021 = $result2021->fetch_assoc()) {
   
$corder = mysqli_fetch_array(mysqli_query($connection,"select * from tradebtc where type ='0' order by id desc limit 1"));
$iduc = $corder['id']; $pricec = $corder['price']; $quantityc = $corder['quantity']; $ccost = number_format($pricec*$quantityc,11);
echo "<br>iduc :" , $iduc . " Pricec ". $pricec . " quantityc " .$quantityc . " ccost ". $ccost;
$porder = mysqli_fetch_array(mysqli_query($connection,"select * from tradebtc where type ='0' AND id < '$iduc' order by id desc limit 1"));
$idup = $porder['id']; $pricep = $porder['price']; $quantityp = $porder['quantity']; $pcost = number_format($pricep*$quantityp,11);
echo "<br>idup :" , $idup . " Pricep ". $pricep . " quantityp " .$quantityp . " pcost " .$pcost;
$allqu = number_format($quantityp+$quantityc,1,".",""); $allcost = number_format($pcost+$ccost,11); 
$newprice = number_format($allcost/$allqu,11,".","");
$fnewprice = number_format($newprice+$newprice*0.25/100,11,".","");
echo "<br> allq ".$allqu . " allcost ".$allcost . " newprice ".$newprice . " fnewprice ".$fnewprice;
 }
} else {
  echo "Type 0 not found";
}

$sql21 = mysqli_fetch_assoc(mysqli_query($connection,"SELECT COUNT(type) AS typp FROM tradebtc where type = '0'"));
$typpp = $sql21['typp']; echo "<br> typpp ".$typpp;

if ($typpp == "2") {
  // output data of each row
      echo "<br>update fnewprice<br>";
    $hh21 = mysqli_query($connection,"update tradebtc set type ='5' where type = '0' AND id ='$idup'");
    $hh22 = mysqli_query($connection,"update tradebtc set sellprice ='$fnewprice' , ma1='$allqu' where type = '0' AND id ='$iduc'");
  
} else {
  echo "hhh0 results";
}
//average price start
?>

///////////////////////////////

<br>up BUY SIDE<br>
<?php
if($signalline < $macd && $hmas =="1") { echo "<br>Buy Trand start";
// buy code start
$symbol = "$pair";
$type = "limit";
$price = "$buy";
$quantityb="$quantity";

if($marketbalance > $dlastbal OR $waitprice > $bid){ echo "previous sell done";
if($price > "0.000000001"){ echo "buy price check<br>";
if($marketbalance > $btclow){ echo "buy fund enough";
if($vwap1 < $lastclose && $lastclose <= $cuopen) { echo "<br>go to buy";

$ch = curl_init();
//do a post
curl_setopt($ch,CURLOPT_URL,$orderurl);
curl_setopt($ch, CURLOPT_USERPWD, $keyapi); // API AND KEY 
curl_setopt($ch, CURLOPT_POST,1);
curl_setopt($ch,CURLOPT_POSTFIELDS,"symbol=$symbol&side=buy&price=$price&quantity=$quantityb&type=$type&timeInForce=GTC");
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
  //return the result of curl_exec,instead
  //of outputting it directly
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
curl_setopt($ch, CURLOPT_HTTPHEADER, array('accept: application/json'));
//curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
$result=curl_exec($ch);
curl_close($ch);
//$result=json_decode($result);
//echo"<pre>";
//print_r($result);
//order buy end
$sita=json_decode($result, true);

$ids=$sita['id'];
$sideask=$sita['side'];
$priceask=$sita['price'];
$quantity123=$sita['quantity'];
$bid123=$sita['clientOrderId'];
echo "sita"; echo "$ids"; 
//insert order details

if($quantity123 == $quantityb) { echo "buy quantity :", $quantity123 . $quantityb;
$query = mysqli_query($connection,"INSERT INTO tradebtc(price,sellprice,quantity,date,clientOrderId,type,lastbal,currency,pair,dlastbal,hma) VALUES ('$priceask','$sellprice','$quantity123','$date','$bid123','0','$coinbalance','$coin','$pair','$marketbalance','1')");
//buy end 
}else {echo "<br>Someting wrong , order not store in database ";}
} else {echo "<br>wait for Buy";}
} else {echo "<br>Buy Balance low";}
} else {echo "<br>wrong price";}
} else {echo "<br>Previous Sell not done";}
} else {echo "Buy trand off";}
//up trade buy first end
//$connection->close();
?>
<?php ////////////////////////////////////
//up sell trand
echo "<br>******<br> up sell Trand <br>";
$sql1sell = "SELECT * FROM tradebtc where type ='0' order by price asc limit 1";
$resulttrady = $connection->query($sql1sell);

if ($resulttrady->num_rows > 0) {
echo "type 0 for sell ";
while($row = $resulttrady->fetch_assoc()) {
    $id = $row["id"]; $pairs = $row["pair"]; $sellprice0 = $row["sellprice"]; $quantitys = $coinbalance1; //$row["quantity"]; 
    $lastbal = $row["lastbal"]; 
    echo "<br> bid  ",$bid.".<br>";
 //up sell vol   
 $quantitys05 = $quantitys*1.5; echo " quantity05 ". $quantitys05;
$jsondata0up = file_get_contents("https://api.hitbtc.com/api/2/public/orderbook/DOGEBTC?volume=$quantitys05");
$data0up = json_decode($jsondata0up, true);
$array_bidup = $data0up['bid'];
foreach ($array_bidup as $rowup) { $bid0 = $rowup["price"];}
$bidup1 = number_format($bid0,11);
echo "<br>up sell price : ". $bidup1 ."<br>";

if($sellprice0 > $bidup1){ $sell = $sellprice0 ;} else { $sell = $bidup1;} 

//$sell = $sellprice0;
   echo "id: " . $id. " - pairs: " . $pairs. "sell price " . $sell. "sell quantity " . $quantitys. "lastbal " . $lastbal. "<br>";
 
}
if($vwap1 > $lastclose && $sellprice0 < $bidup1){ echo "<br>up sell Trand Start";
echo "sell :<br>";
$symbol = "$pairs";
$type = "limit";
$price1 = "$sell";
$quantitys = "$quantitys";
if($price1 > "0.00000001"){ echo "sell price check<br>";
if($coinbalance >= $quantitys){ echo "sell fund enough";
if($lastclose > $cuopen && $typ =="0"){ echo "go for sell";
 
$ch1 = curl_init();
//do a post
curl_setopt($ch1,CURLOPT_URL,$orderurl);
curl_setopt($ch1, CURLOPT_USERPWD, $keyapi); // API AND KEY
curl_setopt($ch1, CURLOPT_POST,1);
curl_setopt($ch1,CURLOPT_POSTFIELDS,"symbol=$symbol&side=sell&price=$price1&quantity=$quantitys&type=$type&timeInForce=GTC");
curl_setopt($ch1, CURLOPT_RETURNTRANSFER,1);
  //return the result of curl_exec,instead
  //of outputting it directly
curl_setopt($ch1, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
curl_setopt($ch1, CURLOPT_HTTPHEADER, array('accept: application/json'));
$result1=curl_exec($ch1);
curl_close($ch1);

//order end
$kali=json_decode($result1, true);
$prices=$kali['price'];
$quantitys1=$kali['quantity'];
$bid124=$kali['clientOrderId'];
echo " sell on";
//insert order details

if ($quantitys == $quantitys1){ echo "sell by kali";
echo "sell order", $bid124;
$querysellup = mysqli_query($connection,"update tradebtc set type = '1' , sell = '$prices', selldate = '$date', hma = '$quantitys1', hmas='1' where id = '$id'");
}
//sell end
} else {echo "<br>wait for sell";}
} else {echo "<br>sell balance low";}
} else {echo "<br>wrong price";}
} else {echo "<br>sell Trand off ";}
} else {echo "<br>sell data not found"; 

//$₹₹₹₹₹₹₹₹₹₹₹₹₹
}
$connection->close();
?>
<?php
if($vwap1 > $lastclose && $signalline < $macd){
$hhh = mysqli_query($connection,"update tradebtc set hmas ='3' where type ='0' AND id ='$idu'"); }
 if($signalline > $macd && $lastclose > $vwap1 && $hmas == "3"){ 
 
 $hh = mysqli_query($connection,"update tradebtc set hmas ='1' where hmas = '3' AND id ='$idu'");
  }
?>
