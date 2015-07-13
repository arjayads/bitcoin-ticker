<?php

require_once 'bitcoin.php';  

function getDateFrom() {
    return $_POST["from"];
}

function getDateTo() {
    return $_POST["to"];
} 
 

$btc = new Bitcoin(getDateFrom(), getDateTo());
$lowestLow = $btc->getLowestLow();
$lowestMarketPrice = $btc->getLowestMarketPrice();
$highestMarketPrice = $btc->getHighestMarketPrice();
$highestHigh = $btc->getHighestHigh();
$currents = $btc->getCurrents(); 
$marketPriceAvg = $btc->getMarketPriceAvg(); 
?>

<html>
<head>
    <title>The Awesome</title>
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css" />
</head>
<body>
    <div style="margin-left:auto; margin-right:auto; width:45%"> 
        <h4>Awesome Trends</h4>
        <div  style="border:1px solid;"> 
            <table class="table table-condensed table-striped">  
                <tbody>
                    <tr>
                        <td>Lowest Low:</td> 
                        <td><?php echo $lowestLow->value; ?></td>
                        <td><?php echo $lowestLow->when; ?></td>
                    </tr>
                    <tr>
                        <td>Lowest Market Price:</td> 
                        <td><?php echo $lowestMarketPrice->value; ?></td>
                        <td><?php echo $lowestMarketPrice->when; ?></td>
                    </tr>
                    <tr>
                        <td>Highest Market Price:</td> 
                        <td><?php echo $highestMarketPrice->value; ?></td>
                        <td><?php echo $highestMarketPrice->when; ?></td>
                    </tr>
                    <tr>
                        <td>Highest High:</td> 
                        <td><?php echo $highestHigh->value; ?></td>
                        <td><?php echo $highestHigh->when; ?></td>
                    </tr>
                    <tr>
                        <td>&nbsp</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Current High:</td> 
                        <td><?php echo $currents->high; ?></td>
                        <td>(difference <?php echo $currents->highMarketPriceMargin; ?>)</td>
                    </tr> 
                    <tr>
                        <td>Current Market Price:</td> 
                        <td><?php echo $currents->marketPrice; ?></td>
                        <td></td>
                    </tr>

                     <tr>
                        <td>Current Low:</td> 
                        <td><?php echo $currents->low; ?></td>
                        <td>(difference <?php echo $currents->lowMarketPriceMargin; ?>)</td>
                    </tr>
                     <tr>
                        <td>&nbsp</td>
                        <td></td>
                        <td></td>
                    </tr>
                     <tr>
                        <td colspan=3>
                            Average Market Price from <?php echo getDateFrom() . ' to ' . getDateTo(); ?> is 
                            <span class="label label-success"><?php echo $marketPriceAvg; ?></span>
                        </td> 
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <script src="/assets/js/bootstrap.min.js" type="text/javascript" /> 
</body>
</html>