<?php

    session_start();

    if (isset($_SESSION['uid']) && isset($_SESSION['account_id'])) {
        require 'dbh.inc.php';

        $status = 'Closed';

        $stmt = $conn->prepare('SELECT symbol, side, entry_date, net_return FROM trades WHERE status=? AND  uid=? AND account_id=? ORDER BY net_return DESC limit 15');
        $stmt->bind_param('sii', $status, $_SESSION['uid'], $_SESSION['account_id']);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 0) {
            //echo '<p style="text-align: center; margin-top: 25px; color: #ccc;">no recent trades</p>';
        }
        else {
            $stmt->bind_result($symbol, $side, $entryDate, $netReturn);

            echo '
                <div style="font-weight: 500;" class="topTradeRow topTradesLabels">
                    <p class="topTradeSymbol">Symbol</p>
                    <p class="topTradeSide">Side</p>
                    <p class="topTradeDate">Entry Date</p>
                    <p class="topTradeReturn">Net Return</p>
                </div>
            ';
        
            while ($stmt->fetch()) {
    
                if ($side == 'Long') {
                    $sideClass = 'greenCol';
                } else {
                    $sideClass = 'redCol';
                }
    
                if ($netReturn >= 0) {
                    $returnClass = 'greenCol';
                } else {
                    $returnClass = 'redCol';
                }
    
                echo '
                    <div class="topTradeRow">
                        <p class="topTradeSymbol">'.$symbol.'</p>
                        <p class="topTradeSide '.$sideClass.'">'.$side.'</p>
                        <p class="topTradeDate">'.$entryDate.'</p>
                        <p class="topTradeReturn '.$returnClass.'">$'.$netReturn.'</p>
                    </div>
                ';
            }

        }

        $stmt->close();
    }