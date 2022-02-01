<?php

    $apiKey = $_GET['key'];

    // get user id attatched to api key

    $stmt = $conn->prepare('SELECT id, uid FROM accounts WHERE api_key = ?');
    $stmt->bind_param('s', $apiKey);
    $stmt->execute();
    $stmt->bind_result($accountId, $userId);
    $stmt->fetch();
    $uid = $userId;
    $accountId = $accountId;
    $stmt->close();

    if (!empty($uid) && !empty($accountId)) {

        date_default_timezone_set("UTC");
        $now = date("Y-m-d H:i:s", time());
        $timeframe = date('Y-m-d H:i:s', strtotime($now) - 30); // 1 minute timeframe

        //get number of requests called in last 1 minute

        $stmt = $conn->prepare('SELECT count(*) FROM api_requests WHERE account_id=? AND uid=? AND request_time >= ?');
        $stmt->bind_param('iis', $uid, $accountId, $timeframe);
        $stmt->execute();
        $stmt->bind_result($requests);
        $stmt->fetch();
        $requests;
        $stmt->close();

        // make the request if rate limit is not exceded

        if ($requests < 100) {

            // create the response array

            $json_data = [
                'trades' => []
            ];

            // check if the sort parameter is set

            if (isset($_GET['sort'])) {
                $sortCol = $_GET['sort'];

                if ($sortCol == 'sym') {
                    $sortCol = 'symbol';
                }
                if ($sortCol == 'sts') {
                    $sortCol = 'status';
                }
                if ($sortCol == 'sde') {
                    $sortCol = 'side';
                }
                if ($sortCol == 'etd') {
                    $sortCol = 'entry_date';
                }
                if ($sortCol == 'exd') {
                    $sortCol = 'exit_date';
                }
                if ($sortCol == 'qty') {
                    $sortCol = 'quantity';
                }
                if ($sortCol == 'etp') {
                    $sortCol = 'entry_price';
                }
                if ($sortCol == 'exp') {
                    $sortCol = 'exit_price';
                }
                if ($sortCol == 'fee') {
                    $sortCol = 'fees';
                }
                if ($sortCol == 'nrt') {
                    $sortCol = 'net_return';
                }
                if ($sortCol == 'roi') {
                    $sortCol = 'net_roi';
                }
                if ($sortCol == 'eta') {
                    $sortCol = 'entry_amount';
                }
                if ($sortCol == 'exa') {
                    $sortCol = 'exit_amount';
                }
                if ($sortCol == 'stl') {
                    $sortCol = 'stop_loss';
                }
                if ($sortCol == 'tkp') {
                    $sortCol = 'take_profit';
                }

            } else {
                $sortCol = 'id';
            }

            if (isset($_GET['order'])) {
                // reverse the order
                if (strtolower($_GET['order']) == 'asc') {
                    $colOrder = 'desc';
                } else {
                    $colOrder = 'asc';
                }
                $sortCol = $sortCol.' '.$colOrder;
            }

            // check if the limit parameter is set

            if (isset($_GET['limit'])) {
                $limit = $_GET['limit'];
            } else {
                $limit = 9999999999;
            }

            if (isset($_GET['symbol']) && strlen($_GET['symbol']) < 9) {
                $sqlParams[] = ' symbol = "'.$_GET['symbol'].'" ';
            }
            if (isset($_GET['side']) && ($_GET['side'] == 'long' || $_GET['side'] == 'short')) {
                $sqlParams[] = ' side = "'.$_GET['side'].'" ';
            }
            if (isset($_GET['status']) && ($_GET['status'] == 'open' || $_GET['status'] ==  'closed')) {
                $sqlParams[] = 'status = "'.$_GET['status'].'" ';
            }
            if (isset($_GET['entrydate']) && strlen($_GET['entrydate']) <= 11) {
                $sqlParams[] = 'entry_date = "'.$_GET['entrydate'].'" ';
            }
            if (isset($_GET['exitdate']) && strlen($_GET['exitdate']) <= 11) {
                $sqlParams[] = 'exit_date = "'.$_GET['exitdate'].'" ';
            }


            if (!empty($sqlParams)) {
                $query = 'SELECT id, symbol, status, side, category, DATE(entry_date), DATE(exit_date), quantity, entry_price, exit_price, fees, net_return, net_roi, entry_amount, exit_amount, stop_loss, take_profit FROM trades 
                WHERE uid=? AND account_id=? AND '.implode(' AND ', $sqlParams).' ORDER BY '.$sortCol.' LIMIT '.$limit.'';
            } else {
                $query = 'SELECT id, symbol, status, side, category, DATE(entry_date), DATE(exit_date), quantity, entry_price, exit_price, fees, net_return, net_roi, entry_amount, exit_amount, stop_loss, take_profit FROM trades 
                WHERE uid=? AND account_id=? ORDER BY '.$sortCol.' LIMIT '.$limit.'';
            }

            $stmt = $conn->prepare($query);
            $stmt->bind_param('ii', $uid, $accountId);
            $stmt->execute();
            $stmt->bind_result($id, $symbol, $status, $side, $category, $entryDate, $exitDate, $qty, $entryPrice, $exitPrice, $fees, $netReturn, $roi, $entryAmt, $exitAmt, $stopLoss, $takeProfit);
            
            $tradeNumber = 0;
            while ($stmt->fetch()) {

                $trade_object = [
                    'symbol' => $symbol,
                    'status' => $status,
                    'side' => $side,
                    'category' => $category,
                    'entry_date' => $entryDate,
                    'exit_date' => $exitDate,
                    'quantity' => $qty,
                    'entry_price' => $entryPrice,
                    'exit_price' => $exitPrice,
                    'fees' => $fees,
                    'net_return' => $netReturn,
                    'roi' => $roi,
                    'entry_amount' => $entryAmt,
                    'exit_amount' => $exitAmt,
                    'stop_loss' => $stopLoss,
                    'take_profit' => $takeProfit,
                    'id' => $id
                ];

                array_push($json_data['trades'], $trade_object);
            }

            $stmt->close();

            $stmt = $conn->prepare('INSERT INTO api_requests (uid, account_id, request_time) VALUES(?,?,?)');
            $stmt->bind_param('iis', $uid, $accountId, $now);
            $stmt->execute();
            $stmt->close();

            echo '<pre>'. json_encode($json_data) . '<pre>';

        } else {
            echo 'rate limit exceded';
        }

    } else {
        echo 'invalid api key';
    }