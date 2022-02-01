<?php

    session_start();

    if (isset($_SESSION['uid']) && isset($_SESSION['account_id'])) {

        require 'dbh.inc.php';

        $curDate = $_POST['curDate'];
        $totalNetReturn = 0;
        $totalBuy = 0;
        $totalSell = 0;
        $outstanding = 0;
        $outstandingCount = 0;
        $tradeCount = 0;
        $dayReturn = 0;
        $weekReturn = 0;
        $monthReturn = 0;
        $wins = 0;
        $losses = 0;
        $totalProfits = 0;
        $totalLosses = 0;
        $totalVolume = 0;
        $longVolume = 0;
        $shortVolume = 0;
        $shareVolume = 0;
        $eps = 0;
    
        $dataArr = [];
        $returnChartData = [];
        $dailyVolumeChart = [];
        $totalVolumeChart = [];
        $dailyProfitsChart = [];
        $dailyLossesChart = [];
        $totalProfitsChart = [];
        $totalLossesChart = [];
        $dailyReturnChartData = [];
        $chartErrMsgs = [];
        $last7Days = [];
        $last30Days = [];
    
        for ($i=0; $i < 7; $i++) {
            $date = new DateTime($curDate);
            $date->modify('-'.$i.'day');
            $dateRslt = $date->format('Y-m-d');
    
            array_push($last7Days, $dateRslt);
        }
    
        for ($i=0; $i < 30; $i++) {
            $date = new DateTime($curDate);
            $date->modify('-'.$i.'day');
            $dateRslt = $date->format('Y-m-d');
    
            array_push($last30Days, $dateRslt);
        }
    
        $stmt = $conn->prepare('SELECT id, entry_price, exit_price, quantity, side, net_return, entry_date, exit_date FROM trades WHERE uid=? AND account_id=? ORDER BY exit_date ASC');
        $stmt->bind_param('ii', $_SESSION['uid'], $_SESSION['account_id']);
        $stmt->execute();
        $stmt->store_result();
        $rows = $stmt->num_rows;
        $stmt->bind_result($id, $entryPrice, $exitPrice, $qty, $side, $netReturn, $entryDate, $exitDate);
    
        while ($stmt->fetch()) {
            
            //total trades
            $tradeCount++;
            settype($netReturn, 'integer');

            $shareVolume += $qty;
    
            //return chart data
            if (!empty($exitDate) && !empty($exitPrice) && !empty($netReturn)) {

                $totalNetReturn += $netReturn;
                $volume = ($entryPrice * $qty) + ($exitPrice * $qty);
                $totalVolume += $volume;

                if ($qty == null) { $qty = 0; }
                if ($exitPrice == null) { $exitPrice = 0; }

                if (strtolower($side) == 'long') {
                    $longVolume += $volume;
                } else {
                    $shortVolume += $volume;
                }

                if ($netReturn >= 0) {
                    $totalProfits += $netReturn;
                    $pl = 'profit';
                } 
                else {
                    $totalLosses += $netReturn;
                    $pl = 'loss';
                }
    
                //return chart data
                if (array_key_exists($exitDate, $returnChartData)) {
                    $returnChartData[$exitDate] += round($netReturn);
                    $dailyReturnChartData[$exitDate] += round($netReturn);
                }
                else {
                    $returnChartData[$exitDate] = round($totalNetReturn);
                    $dailyReturnChartData[$exitDate] = round($netReturn);
                }

                // volume charts
                if (array_key_exists($exitDate, $dailyVolumeChart)) {
                    $totalVolumeChart[$exitDate] += $volume;
                    $dailyVolumeChart[$exitDate] += $volume;
                } else {
                    $totalVolumeChart[$exitDate] = $totalVolume;
                    $dailyVolumeChart[$exitDate] = $volume;
                }

                if (array_key_exists($exitDate, $dailyProfitsChart)) {
                    if ($pl == 'profit') {
                        $totalProfitsChart[$exitDate] += $netReturn;
                        $dailyProfitsChart[$exitDate] += $netReturn;
                     }
                } else {
                    if ($pl == 'profit') {
                        $dailyProfitsChart[$exitDate] = $netReturn;
                    } else {
                        $dailyProfitsChart[$exitDate] = 0;
                    }
                    $totalProfitsChart[$exitDate] = $totalProfits;
                }

                if (array_key_exists($exitDate, $dailyLossesChart)) {
                    if ($pl == 'loss') {
                        $totalLossesChart[$exitDate] += abs($netReturn);
                        $dailyLossesChart[$exitDate] += abs($netReturn);
                    }
                } else {
                    if ($pl == 'loss') {
                        $dailyLossesChart[$exitDate] = abs($netReturn);
                    } else {
                        $dailyLossesChart[$exitDate] = 0;
                    }
                    $totalLossesChart[$exitDate] = abs($totalLosses);
                }
    
                $date = new DateTime($exitDate);
                $exitDateOnly = $date->format('Y-m-d');
    
                // daily net return
                if ($exitDateOnly == $curDate) {
                    $dayReturn += $netReturn;
                }
    
                // 7 day net return
                if (in_array($exitDateOnly, $last7Days)) {
                    $weekReturn += $netReturn;
                }
    
                // 30 day net return
                if (in_array($exitDateOnly, $last30Days)) {
                    $monthReturn += $netReturn;
                }
    
                // total wins and losses
                if ($netReturn >= 0) {
                    $wins++;
                } else {
                    $losses++;
                }
    
            }
    
            //spreadsheet error messages
            if (empty($exitDate) && !empty($exitPrice)) {
                $errMsg = '<p tid="'.$id.'">• Trade closed without exit date</p>';
                array_push($chartErrMsgs, $errMsg);
            }
            if (!empty($exitDate) && empty($exitPrice)) {
                $errMsg = '<p tid="'.$id.'">• Exit date found without exit price</p>';
                array_push($chartErrMsgs, $errMsg);
            }
    
        }

        $avgTradeReturn = round($totalNetReturn / $tradeCount, 2);
        $tradeCount = number_format($tradeCount, '0', '0', ',');
        $eps = $netReturn / $shareVolume;
    
        //add start date (0) to pl chart data
    
        $firstExitDate = new DateTime(array_key_first($returnChartData));
        $firstExitDate = $firstExitDate->format('Y-m-d');
        $dayZero = date('Y-m-d',(strtotime ( '-1 day' , strtotime ($firstExitDate) ) ));
    
        $returnChartData = array($dayZero => 0) + $returnChartData;
        $dailyReturnChartData = array($dayZero => 0) + $dailyReturnChartData;
        $dailyVolumeChart = array($dayZero => 0) + $dailyVolumeChart;
        $totalVolumeChart = array($dayZero => 0) + $totalVolumeChart;
        $dailyProfitsChart = array($dayZero => 0) + $dailyProfitsChart;
        $dailyLossesChart = array($dayZero => 0) + $dailyLossesChart;
        $totalProfitsChart = array($dayZero => 0) + $totalProfitsChart;
        $totalLossesChart = array($dayZero => 0) + $totalLossesChart;
        
    
        array_push($dataArr, $returnChartData, $totalNetReturn, $chartErrMsgs, $dailyReturnChartData, $tradeCount, $dayReturn, $weekReturn, $monthReturn, $wins, $losses, $dailyProfitsChart, $dailyLossesChart, $totalProfits, $totalLosses, $dailyVolumeChart, $totalVolume, $longVolume, $shortVolume, $dailyProfitsChart, $dailyLossesChart, $totalVolumeChart, $totalProfitsChart, $totalLossesChart, $avgTradeReturn, $shareVolume, $eps);
    
        echo json_encode($dataArr);

    }





















    /*

    $stmt = $conn->prepare('SELECT MIN(date_sold), MAX(date_sold) FROM spreadsheet WHERE date_sold IS NOT NULL');
    $stmt->execute();
    $stmt->bind_result($earliestDate1, $oldestDate1);
    $stmt->fetch();
    $stmt->close();

    $stmt = $conn->prepare('SELECT MIN(buy_date), MAX(buy_date) FROM packs WHERE buy_date IS NOT NULL');
    $stmt->execute();
    $stmt->bind_result($earliestDate2, $oldestDate2);
    $stmt->fetch();
    $stmt->close();

    array_push($dateArr, $earliestDate1, $oldestDate1, $earliestDate2, $oldestDate2);

    $earliestDate = min($dateArr);
    $oldestDate = max($dateArr);

    $totalSell += $sold;

    if (array_key_exists($exitDate, $sellChartData)) {
        $sellChartData[$exitDate] += $exitPrice;
    } 
    else {
        $sellChartData[$exitDate] = $totalSell;
    }

    //$stmt = $conn->prepare('SELECT price, buy_date FROM packs ORDER BY buy_date ASC');

    $stmt->close();

    $stmt = $conn->prepare('SELECT bought, date_bought FROM spreadsheet ORDER BY date_bought ASC');
    //$stmt->bind_param('ss', $earliestDate1, $oldestDate1);
    $stmt->execute();
    $stmt->store_result();
    $rows = $stmt->num_rows;
    $stmt->bind_result($entryPrice, $entryDate);

    while ($stmt->fetch()) {

        if (!empty($entryDate)) {
            //total buy chart loop
            $totalBuy += $entryPrice;

            if (array_key_exists($entryDate, $buyChartData)) {
                $buyChartData[$entryDate] += $entryPrice;
            } 
            else {
                $buyChartData[$entryDate] = $totalBuy;
            }
        }

    }

    function sortFunction( $a, $b ) {
        return strtotime($a) > strtotime($b);
    }

    uksort($returnChartData, 'sortFunction');

    array_push($dataArr, $returnChartData, $totalNetReturn, $outstanding, $outstandingCount, $buyChartData, $sellChartData);

    echo json_encode($dataArr);

    */