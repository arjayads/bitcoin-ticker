<?php  
require_once 'bitcoin.php'; 

// fetch JSON and persist
$btc = new Bitcoin();
$tickerObj = $btc->getTickerObj();
$btc->persistTicker($tickerObj);

?>