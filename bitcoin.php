<?php

class Bitcoin {
    private $username = 'bitcoin';
    private $password = 'bitcoin';
    private $from;
    private $to;

    function __construct($from=null, $to=null) {
        $this->from = $from;
        $this->to = $to;
    }

    function getConnection() {
        try { 
           return new PDO('mysql:host=localhost;dbname=bitcoin', $this->username, $this->password); 
        } catch(PDOException $e) {
            die('ERROR: ' . $e->getMessage());
        }    
    }

    function getTickerObj() { 
        $json = file_get_contents('https://btc-e.com/api/2/btc_usd/ticker');
        return json_decode($json);   
    }

    function persistTicker($tickerObj) {
        $high = $tickerObj->ticker->high;
        $low = $tickerObj->ticker->low;
        $avg = $tickerObj->ticker->avg;
        $vol = $tickerObj->ticker->vol;
        $vol_cur = $tickerObj->ticker->vol_cur;
        $last = $tickerObj->ticker->last;
        $buy = $tickerObj->ticker->buy; 
        $sell = $tickerObj->ticker->sell;
        $updated = $tickerObj->ticker->updated; 
        $server_time = $tickerObj->ticker->server_time; 

        try {
            $conn = $this->getConnection();

            $stmt = $conn->prepare('INSERT INTO 
                                    ticker 
                                    VALUES(:high, :low, :avg, :vol, 
                                            :vol_cur, :last, :buy, 
                                            :sell, :updated, :server_time,
                                            :hi_low_diff, :hi_last_market_diff,
                                            :low_last_market_diff, FROM_UNIXTIME(:updated_date_time))');

            $values = array(
                        ':high' => $high, 
                        ':low' => $low, 
                        ':avg' => $avg, 
                        ':vol' => $vol, 
                        ':vol_cur' => $vol_cur, 
                        ':last' => $last, 
                        ':buy' => $buy, 
                        ':sell' => $sell, 
                        ':updated' => $updated, 
                        ':server_time' => $server_time,
                        ':hi_low_diff' => $high - $low, 
                        ':hi_last_market_diff' => $high - $last, 
                        ':low_last_market_diff' => $low - $last,
                        ':updated_date_time' => $updated,
                    );

            $stmt->execute($values); 

            print "Insert OK!" . PHP_EOL;

            $conn = null;
        } catch(PDOException $e) {
            die('ERROR: ' . $e->getMessage());
        } 
    } 

    function getLowestLow() {
        $lowestLow = new stdClass();
        
        try {
            $conn = $this->getConnection();

            // some rows have same low values
            // get the latest one 
            // GROUP BY NO! NO!
            $stmt = $conn->prepare("SELECT
                                    low,
                                    DATE_FORMAT(updated_date_time, '%D %b %Y %H:%i')
                                    FROM ticker
                                    WHERE low = (SELECT MIN(low) as lowest_low FROM ticker
                                                WHERE updated_date_time > :from   # between ranges
                                                AND updated_date_time < :to     # between ranges
                                                ) 
                                    ORDER BY updated DESC LIMIT 1"); 

            $stmt->execute(array(':from' => $this->from, ':to' => $this->to)); 
            $row = $stmt->fetch();

            $lowestLow->value = '$'.number_format($row[0]);
            $lowestLow->when = $row[1]; 

            $conn = null;
        } catch(PDOException $e) {
            die('ERROR: ' . $e->getMessage());
        } 

        return $lowestLow;
    }

    function getLowestMarketPrice() {
       $lowestMarketPrice = new stdClass();
        
        try {
            $conn = $this->getConnection();
 
            // GROUP BY NO! NO!
            $stmt = $conn->prepare("SELECT
                                    buy,
                                    DATE_FORMAT(updated_date_time, '%D %b %Y %H:%i')
                                    FROM ticker
                                    WHERE buy = (SELECT MIN(buy) FROM ticker
                                                WHERE updated_date_time > :from   # between ranges
                                                AND updated_date_time < :to     # between ranges
                                                ) 
                                    ORDER BY updated DESC LIMIT 1"); 

            $stmt->execute(array(':from' => $this->from, ':to' => $this->to)); 
            $row = $stmt->fetch();

            $lowestMarketPrice->value = '$'.number_format($row[0]);
            $lowestMarketPrice->when = $row[1]; 

            $conn = null;
        } catch(PDOException $e) {
            die('ERROR: ' . $e->getMessage());
        } 

        return $lowestMarketPrice;
    }

    function getHighestMarketPrice() {
        $highestMarketPrice = new stdClass();
        
        try {
            $conn = $this->getConnection();
 
            // GROUP BY NO! NO!
            $stmt = $conn->prepare("SELECT
                                    buy,
                                    DATE_FORMAT(updated_date_time, '%D %b %Y %H:%i')
                                    FROM ticker
                                    WHERE buy = (SELECT MAX(buy) FROM ticker
                                                WHERE updated_date_time > :from   # between ranges
                                                AND updated_date_time < :to     # between ranges
                                                ) 
                                    ORDER BY updated DESC LIMIT 1"); 

            $stmt->execute(array(':from' => $this->from, ':to' => $this->to)); 
            $row = $stmt->fetch();

            $highestMarketPrice->value = '$'.number_format($row[0]);
            $highestMarketPrice->when = $row[1]; 

            $conn = null;
        } catch(PDOException $e) {
            die('ERROR: ' . $e->getMessage());
        } 

        return $highestMarketPrice;
    }

    function getHighestHigh() {
        $highestHigh = new stdClass();
        
        try {
            $conn = $this->getConnection();
 
            // GROUP BY NO! NO!
            $stmt = $conn->prepare("SELECT
                                    high,
                                    DATE_FORMAT(updated_date_time, '%D %b %Y %H:%i')
                                    FROM ticker
                                    WHERE high = (SELECT MAX(high) FROM ticker
                                                WHERE updated_date_time > :from   # between ranges
                                                AND updated_date_time < :to     # between ranges
                                                ) 
                                    ORDER BY updated DESC LIMIT 1"); 

            $stmt->execute(array(':from' => $this->from, ':to' => $this->to)); 
            $row = $stmt->fetch();

            $highestHigh->value = '$'.number_format($row[0]);
            $highestHigh->when = $row[1]; 

            $conn = null;
        } catch(PDOException $e) {
            die('ERROR: ' . $e->getMessage());
        } 

        return $highestHigh;
    }

    function getCurrents() {
        $current = new stdClass();
        
        try {
            $conn = $this->getConnection();
  
            $stmt = $conn->prepare("SELECT
                                    high,
                                    low,
                                    buy,
                                    hi_last_market_diff,
                                    ABS(low_last_market_diff)
                                    FROM ticker
                                    ORDER BY updated DESC LIMIT 1"); 

            $stmt->execute(); 
            $row = $stmt->fetch();

            $current->high                  = '$'.number_format($row[0]);
            $current->marketPrice           = '$'.number_format($row[1]);
            $current->low                   = '$'.number_format($row[2]);
            $current->highMarketPriceMargin = '$'.number_format($row[3]);
            $current->lowMarketPriceMargin  = '$'.number_format($row[4]); 

            $conn = null;
        } catch(PDOException $e) {
            die('ERROR: ' . $e->getMessage());
        } 

        return $current;
    }

    function getMarketPriceAvg() {
        $marketPriceAvg = 0;
        
        try {
            $conn = $this->getConnection();
  
            $stmt = $conn->prepare("SELECT
                                    AVG(buy) 
                                    FROM ticker
                                    WHERE updated_date_time > :from   # between ranges
                                    AND updated_date_time < :to       # between ranges
                                    LIMIT 1"); 

            $stmt->execute(array(':from' => $this->from, ':to' => $this->to)); 
            $row = $stmt->fetch(); 

            $marketPriceAvg                 = '$'.number_format($row[0]); 

            $conn = null;
        } catch(PDOException $e) {
            die('ERROR: ' . $e->getMessage());
        } 

        return $marketPriceAvg;
    }


} 
 