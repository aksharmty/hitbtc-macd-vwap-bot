price action 30 minutes<br> 
<?php 
include "connect.php";
define('TIMEZONE', 'Asia/kolkata');
date_default_timezone_set(TIMEZONE);
  $date = DATE("Y-m-d H:i:s");
  $keyapi = 'HITBTC_API_KEY:HITBTC_SECRET_KEY'; //wrtite your api key
$balurl = 'https://api.hitbtc.com/api/2/trading/balance';
$orderurl = 'https://api.hitbtc.com/api/2/order';

//  $coinsql = mysqli_fetch_array(mysqli_query($connection,"SELECT * FROM coin where coin ='DOGE' AND market = 'BTC'"));// order by RAND() limit 1"));
$coin = "BTC";//$coinsql['coin'];
$market = "USD";//$coinsql['market'];
//$quantity = $coinsql['quantity'];
$pair = $coin.$market;
echo "pair : ",$pair; 

$sql123 = mysqli_query($connection,"TRUNCATE TABLE rsi");
$urlcan = 'https://api.hitbtc.com/api/2/public/candles/BTCUSD?period=M30&sort=DESC&limit=100';
$curlcan = curl_init();
curl_setopt($curlcan, CURLOPT_URL, $urlcan);
curl_setopt($curlcan, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curlcan, CURLOPT_HEADER, false);
$datacan = curl_exec($curlcan);
curl_close($curlcan);
//print_r($datacan);
$array=json_decode($datacan, true);
  //$array = json_decode($data, true); //Convert JSON String into PHP Array
  foreach($array as $row) //Extract the Array Values by using Foreach Loop
          {
   $query .= mysqli_query($connection,"INSERT INTO rsi(open,close,min,max,date) VALUES ('".$row["open"]."','".$row["close"]."','".$row["min"]."','".$row["max"]."','".$row["timestamp"]."'); "); 
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
echo "<br> market bal : ", $market . ':' . $marketbalance;
 //coin bal 
$need0 = array(    //1 =>'DOGE',
    $coin
);
foreach ($data as $key => $value) {
          if (in_array($data[$key]['currency'], $need0)) {
              $coinbalance=$data[$key]['available'];
              $reserved = $data[$key]['reserved'];
          }}
          echo " coin bal : ",$coin . ':' . $coinbalance;
?>
<?php
//ask - bid check
$urlask = 'https://api.hitbtc.com/api/2/public/ticker/BTCUSD';
$curlask = curl_init();
curl_setopt($curlask, CURLOPT_URL, $urlask);
curl_setopt($curlask, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curlask, CURLOPT_HEADER, false);
$dataask = curl_exec($curlask);
curl_close($curlask);
//print_r($dataask);
$ass=json_decode($dataask, true);
$ask=$ass['ask'];
$bid=$ass['bid'];
echo "<br>ASK : ", $ask . " BID " . $bid ."<br>";
?>
<?php 
$cucan = mysqli_fetch_assoc(mysqli_query($connection,"SELECT * FROM rsi order by id asc limit 1"));
$cuid = $cucan['id']; echo "<br>cu id ". $cuid;
$cuopen = $cucan['open']; echo "<br>cu open ". $cuopen;

$lastcan = mysqli_fetch_assoc(mysqli_query($connection,"SELECT * FROM rsi where open > close order by id asc limit 1"));
$lastid = $lastcan['id']; echo "<br> id ". $lastid;
$lastclose = $lastcan['close']; echo "<br> close ". $lastclose;
$lastopen = $lastcan['open'];   echo "<br> open ".$lastopen;
$lastmin = $lastcan['min'];     echo "<br> min ". $lastmin;
$lastmax = $lastcan['max'];     echo "<br> max ". $lastmax;
$lastdate = $lastcan['date'];   echo "<br> date ". $lastdate;
echo "<br>min ";
$mincan = mysqli_fetch_assoc(mysqli_query($connection,"SELECT * FROM rsi where id > '$lastid' AND min < '$lastmin' AND close < open order by id asc limit 1"));
$minid = $mincan['id']; echo "<br> id ". $minid;
//$minclose = $mincan['close']; echo "<br> close ". $minclose;
//$minopen = $mincan['open'];   echo "<br> open ".$minopen;
$minmin = $mincan['min'];     echo "<br> min ". $minmin;
//$minmax = $mincan['max'];     echo "<br> max ". $minmax;
//$mindate = $mincan['date'];   echo "<br> date ". $mindate;
echo "<br> max ";
$maxcan = mysqli_fetch_assoc(mysqli_query($connection,"SELECT * FROM rsi where id > '$lastid' AND max > '$lastmax' AND close > open order by id asc limit 1"));
$maxid = $maxcan['id']; echo "<br> id ". $maxid;
//$maxclose = $maxcan['close']; echo "<br> close ". $maxclose;
//$maxopen = $maxcan['open'];   echo "<br> open ".$maxopen;
//$maxmin = $maxcan['min'];     echo "<br> min ". $maxmin;
$maxmax = $maxcan['max'];     echo "<br> max ". $maxmax;
//$maxdate = $maxcan['date'];   echo "<br> date ". $maxdate;

//ma
$tar0 = number_format($maxmax-$minmin,2,".","");
$tar1 = number_format($tar0/2,2,".","");
$target = number_format($maxmax+$tar1,2,".","");
echo ("<br> This is the tar0 : $tar0");
echo ("<br> This is the tar1 : $tar1");
echo ("<br> This is the target : $target");
?>
<?php
$askup0 = mysqli_fetch_array(mysqli_query($connection,"select * from tradeusd order by id desc limit 1"));
$idu = $askup0['id']; echo "<br>idu :" , $idu;
$hma = $askup0['hma']; echo "<br>hma :" , $hma;
$hmas = $askup0['hmas']; echo "<br>hmas :" , $hmas;
$dlastbal = $askup0['dlastbal']; echo "<br>dlastbal :" , $dlastbal;
$lastbal = $askup0['lastbal']; echo "<br>lastbal :" , $lastbal;
$lastprice = $askup0['price'];
$waitprice = number_format($lastprice-$lastprice*10/100,2);echo "wait price ".$waitprice;
$buy01 = $ask;
$qq0 = $marketbalance/$buy01/"4"; $quantity=floor($qq0/1)*1; 
echo "<br> Qq", $quantity; $quantityd=$quantity*2; 
?>
<?php
//vol and quantity
$jsondata0 = file_get_contents("https://api.hitbtc.com/api/2/public/orderbook/BTCUSD?volume=$quantityd");
$data0 = json_decode($jsondata0, true);
$array_ask = $data0['ask'];
foreach ($array_ask as $row) { $ask0 = $row["price"];}
$ask1 = number_format($ask0,2);
echo "<br>Buy price : ". $ask1 ."<br>";
$buy = $ask1;
$sell0 = $buy+$buy*0.23/100; 
$sellprice = number_format($sell0,2, ".", ""); echo "<br>sellprice :",$sellprice;
$btcl = $quantity*$buy; $btclow = number_format($btcl,2);
echo "<br>btc low :",$btclow;
?>

<br>UP SIDE<br>
<?php
//up buy trand

if($target >= $sellprice && $cuopen > $maxmax) { echo "<br>Up Buy Trand start";
// buy code start
$symbol = "$pair";
$type = "limit";
$price = "$buy";
$quantityb="$quantity";

if($marketbalance > $dlastbal OR $waitprice > $bid){ echo "previous sell done";
if($price > "0.000000001"){ echo "buy price check<br>";
if($marketbalance > $btclow){ echo "buy fund enough";
if($hmas == "1"){ echo "hmas ok";

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
$query = mysqli_query($connection,"INSERT INTO tradeusd(price,sellprice,quantity,date,clientOrderId,type,lastbal,currency,pair,dlastbal,hma) VALUES ('$priceask','$sellprice','$quantity123','$date','$bid123','0','$coinbalance','$coin','$pair','$marketbalance','1')");
//buy end 
}else {echo "<br>Someting wrong , order not store in database ";}
} else {echo "<br>Hmas wait";}
} else {echo "<br>Buy Balance low";}
} else {echo "<br>wrong price";}
} else {echo "<br>Previous Sell not done";}
} else {echo "Buy trand off";}
?>
<?php ////////////////////////////////////
//sell trand
echo "<br>******<br> sell Trand <br>";
$sql1 = "SELECT * FROM tradeusd where type ='0' order by price asc limit 1";
$resulttrady = $connection->query($sql1);

if ($resulttrady->num_rows > 0) {
echo "type 0 for sell ";
while($row = $resulttrady->fetch_assoc()) {
    $id = $row["id"]; $pairs = $row["pair"]; $sellprice0 = $row["sellprice"]; $quantitys = $row["quantity"]; $lastbal = $row["lastbal"]; 
    echo "<br> bid  ",$bid.".<br>";
if($sellprice0 > $bid){ $sell = $sellprice0 ;} else { $sell = $bid;} 

//$sell = $sellprice0;
    
    echo "id: " . $id. " - pairs: " . $pairs. "sell price " . $sell. "sell quantity " . $quantitys. "lastbal " . $lastbal. "<br>";
 
}
if($lastclose >= $cuopen){ echo "<br>Up sell Trand Start";
echo "sell :<br>";
$symbol = "$pairs";
$type = "limit";
$price1 = "$sell";
$quantitys= "$quantitys";
if($price1 > "0.00000001"){ echo "sell price check<br>";
if($coinbalance >= $quantitys){ echo "sell fund enough";

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
$querysellup = mysqli_query($connection,"update tradeusd set type ='1' , sell ='$prices', selldate='$date', hma = '$quantitys1' where id ='$id'");
}
//sell end
} else {echo "<br>sell balance low";}
} else {echo "<br>wrong price";}
} else {echo "<br>sell data not found";}
} else {echo "<br>sell Trand off ";}

$hamscan = mysqli_fetch_assoc(mysqli_query($connection,"SELECT * FROM rsi where id = 2"));
$hamsopen = $hamscan['open']; echo "<br>hams open ". $hamsopen;
$hamsclose = $hamscan['close']; echo "<br>hams close ". $hamsclose;
if($hamsclose < $hamsopen){ echo " hams red candle"; 
    $hamsup = mysqli_query($connection,"update tradeusd set hmas ='1' where id ='$idu'");
} else { echo "wait hams green candle";}
?>
