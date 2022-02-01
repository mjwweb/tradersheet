<?php

    session_start();

    if (isset($_SESSION['uid'])) {

        function loadSpreadsheetLog($start, $limit) {
            global $conn;

            $spreadsheetRow = 0;

            /*
            // query all trades
            if ($openTrades == 'true' && $closedTrades == 'true') {

            }
            // query open trades
            else if ($openTrades == 'true' && $closedTrades == 'false') {
                $status = 'Open';
                $stmt = $conn->prepare('SELECT id, symbol, status, side, entry_date, exit_date, quantity, entry_price, exit_price, fees, net_return, net_roi, entry_amount, exit_amount, stop_loss, take_profit FROM trades 
                                        WHERE uid=? AND status=? ORDER BY '.$order.' LIMIT '.$start.', '.$limit.' ');
                $stmt->bind_param('is', $_SESSION['uid'], $status);
            }
            // query closed trades
            else if ($closedTrades == 'true' && $openTrades == 'false') {
                $status = 'Closed';
                $stmt = $conn->prepare('SELECT id, symbol, status, side, entry_date, exit_date, quantity, entry_price, exit_price, fees, net_return, net_roi, entry_amount, exit_amount, stop_loss, take_profit FROM trades 
                                        WHERE uid=? AND status=? ORDER BY '.$order.' LIMIT '.$start.', '.$limit.' ');
                $stmt->bind_param('is', $_SESSION['uid'], $status);
            }
            */

            $stmt = $conn->prepare('SELECT id, symbol, status, side, entry_date, exit_date, quantity, entry_price, exit_price, fees, net_return, net_roi, entry_amount, exit_amount, stop_loss, take_profit FROM trades 
                                    WHERE uid=? ORDER BY sortId LIMIT '.$start.', '.$limit.' ');
            $stmt->bind_param('i', $_SESSION['uid']);
            $stmt->execute();
            $stmt->bind_result($id, $symbol, $status, $side, $entryDate, $exitDate, $qty, $entryPrice, $exitPrice, $fees, $netReturn, $roi, $entryAmt, $exitAmt, $stopLoss, $takeProfit);

            while ($stmt->fetch()) {

                if ($netReturn >= 0) {
                    $returnClass = 'greenCol';
                } else {
                    $returnClass = 'redCol';
                }

                if ($status == 'Open') {
                    $statusClass = 'greenCol';
                } else {
                    $statusClass = 'redCol';
                }

                if ($roi >= 0) {
                    $roiClass = 'greenCol';
                } else {
                    $roiClass = 'redCol';
                }

                if (!empty($roi)) {
                    $roi = $roi.'%';
                }

                echo '
                <div class="tradeLogDataRow tradeLogRow spreadsheetRow" id="'.$id.'">
                    <div class="noteBtnCol column">
                        <i class="fal fa-comment-alt-lines showTradeNotes"></i>
                    </div>
                    <div class="statusCol column">
                        <input value="'.$status.'" disabled class="disabledInpt mInput '.$statusClass.' " />
                    </div>
                    <div class="symbolCol column">
                        <input style="text-transform: uppercase;" value="'.$symbol.'" class="mInput" />
                    </div>
                    <div class="sideCol column">
                        <input readonly="readonly" value="'.$side.'" class="mInput" />
                    </div>
                    <div class="qtyCol column">
                        <input value="'.(float)$qty.'" class="mInput" />
                    </div>
                    <div class="entryPriceCol column">
                        <input value="'.$entryPrice.'" class="mInput" />
                    </div>
                    <div class="entryDateCol column">
                        <input value="'.$entryDate.'" class="mInput" />
                        <!--<i class="fal fa-clock addTradeTime"></i>-->
                    </div>
                    <div class="exitPriceCol column">
                        <input value="'.$exitPrice.'" class="mInput" />
                    </div>
                    <div class="exitDateCol column">
                        <input value="'.$exitDate.'" class="mInput" />
                        <!--<i class="fal fa-clock addTradeTime"></i>-->
                    </div>
                    <div class="stopLossCol">
                        <input value="'.$stopLoss.'" type="text" class="mInput" />
                    </div>
                    <div class="takeProfitCol">
                        <input value="'.$takeProfit.'" type="text" class="mInput" />
                    </div>
                    <div class="feeCol column">
                        <input value="'.$fees.'" class="mInput" />
                    </div>
                    <div class="entryAmtCol column">
                        <input disabled value="'.$entryAmt.'" class="disabledInpt mInput" />
                    </div>
                    <div class="exitAmtCol column">
                        <input disabled value="'.$exitAmt.'" class="disabledInpt mInput" />
                    </div>
                    <div class="netReturnCol column">
                        <input disabled value="'.$netReturn.'" class="disabledInpt mInput '.$returnClass.'" />
                    </div>
                    <div class="netRoiCol column">
                        <input disabled value="'.$roi.'" class="disabledInpt mInput '.$roiClass.'" />
                    </div>
                    <div class="tradeChbxCol column">
                        <input type="checkbox" class="tradeChbx" />
                    </div>
                </div>';
            }

            $stmt->close();
        }

        function loadOpenTrades($start, $limit, $order) {
            global $conn;

            $stmt = $conn->prepare('SELECT id, symbol, side, entry_date, quantity, entry_price, exit_price, entry_amount, exit_amount, stop_loss, take_profit FROM trades 
                                    WHERE exit_price IS NULL OR exit_date IS NULL ORDER BY '.$order.' LIMIT '.$start.', '.$limit.'');
            $stmt->execute();
            $stmt->bind_result($id, $symbol, $side, $entryDate, $qty, $entryPrice, $exitPrice, $entryAmt, $exitAmt, $stopLoss, $takeProfit);

            while ($stmt->fetch()) {

            echo '
            <div tid="'.$id.'" class="openTradesDataRow openTradesRow spreadsheetRow">
                <div class="tradeLogNumCol">
                    <input value="'.$id.'" disabled class="disabledInpt mInput" />
                </div>
                <div class="openSymbolCol">
                    <input disabled value="'.$symbol.'" type="text" class="mInput" />
                </div>
                <div class="openSideCol">
                    <input disabled value="'.$side.'" type="text" class="mInput" />
                </div>
                <div class="openDateCol">
                    <input disabled value="'.$entryDate.'" type="text" class="mInput" />
                </div>
                <div class="openQtyCol">
                    <input disabled value="'.$qty.'" type="text" class="mInput" />
                </div>
                <div class="openEntryCol">
                    <input disabled value="'.$entryPrice.'" type="text" class="mInput" />
                </div>
                <div class="openAmountCol">
                    <input disabled value="'.$entryAmt.'" type="text" class="mInput" />
                </div>
                <div class="stopLossCol">
                    <input value="'.$stopLoss.'" type="text" class="mInput" />
                </div>
                <div class="takeProfitCol">
                    <input value="'.$takeProfit.'" type="text" class="mInput" />
                </div>
            </div>';
            }

            $stmt->close();
        }

        function loadClosedTrades($start, $limit, $order) {
            global $conn;

            $stmt = $conn->prepare('SELECT id, symbol, side, exit_date, quantity, entry_price, exit_price, entry_amount, exit_amount, stop_loss, take_profit, net_return FROM trades 
                                    WHERE entry_price IS NOT NULL AND exit_price IS NOT NULL AND entry_date IS NOT NULL AND exit_date IS NOT NULL 
                                    ORDER BY '.$order.' LIMIT '.$start.', '.$limit.'');
            $stmt->execute();
            $stmt->bind_result($id, $symbol, $side, $exitDate, $qty, $entryPrice, $exitPrice, $entryAmt, $exitAmt, $stopLoss, $takeProfit, $netReturn);

            while ($stmt->fetch()) {

            if ($netReturn >= 0) {
                $returnClass = 'greenCol';
            } else {
                $returnClass = 'redCol';
            }

            echo '
            <div tid="'.$id.'" class="closedTradesDataRow closedTradesRow spreadsheetRow">
                <div class="tradeLogNumCol">
                    <input value="'.$id.'" disabled class="disabledInpt mInput" />
                </div>
                <div class="closedSymbolCol">
                    <input disabled value="'.$symbol.'" type="text" class="mInput disabledInpt" />
                </div>
                <div class="closedSideCol">
                    <input disabled value="'.$side.'" type="text" class="mInput disabledInpt" />
                </div>
                <div class="closedDateCol">
                    <input disabled value="'.$exitDate.'" type="text" class="mInput disabledInpt" />                    
                </div>
                <div class="closedQtyCol">
                    <input disabled value="'.$qty.'" type="text" class="mInput disabledInpt" />
                </div>
                <div class="closedExitCol">
                    <input disabled value="'.$exitPrice.'" type="text" class="mInput disabledInpt" />
                </div>
                <div class="closedAmountCol">
                    <input disabled value="'.$exitAmt.'" type="text" class="mInput disabledInpt" />
                </div>
                <div class="closedStopCol">
                    <input value="'.$stopLoss.'" type="text" class="mInput" />
                </div>
                <div class="closedTakeCol">
                    <input value="'.$takeProfit.'" type="text" class="mInput" />
                </div>
                <div class="closedReturnCol">
                    <input disabled value="'.$netReturn.'" type="text" class="mInput disabledInpt '.$returnClass.'" />
                </div>
                <div class="closedRoiCol column">
                    <input disabled value="" class="disabledInpt mInput" />
                </div>
            </div>';
            }
        }

        function loadTradeNotes() {
            global $conn;

            //$stmt = $conn->prepare('SELECT notes')
        }

        function dollarSign($num) {
            if ($num >= 0) {
                $returnClass = 'greenCol';
                $num = '$'.$num;
            } 
            else {
                $returnClass = 'redCol';
                $num = substr_replace($num, '$', 1, 0);
            }
            return $num;
        }
    }