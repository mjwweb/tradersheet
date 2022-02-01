<?php

    session_start();
    
    if (isset($_SESSION['uid'])) {

        require 'dbh.inc.php';
        $tradeId = $_POST['id'];

        $stmt = $conn->prepare('SELECT id, symbol, status, side, entry_date, exit_date, quantity, entry_price, exit_price, fees, net_return, net_roi, entry_amount, exit_amount, stop_loss, take_profit 
                                FROM trades WHERE uid=? AND id=?');
        $stmt->bind_param('ii', $_SESSION['uid'], $tradeId);
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
                <div class="noteBtnCol">
                    <i class="fal fa-comment-alt-lines showTradeNotes"></i>
                </div>
                <div class="statusCol">
                    <input value="'.$status.'" disabled class="disabledInpt mInput '.$statusClass.' " />
                </div>
                <div class="symbolCol column">
                    <input value="'.$symbol.'" class="mInput" />
                </div>
                <div class="sideCol column">
                    <input readonly="readonly" value="'.$side.'" class="mInput" />
                </div>
                <div class="qtyCol column">
                    <input value="'.$qty.'" class="mInput" />
                </div>
                <div class="entryPriceCol column">
                    <input value="'.$entryPrice.'" class="mInput" />
                </div>
                <div class="entryDateCol column">
                    <input value="'.$entryDate.'" class="mInput" />
                    <i class="fal fa-clock addTradeTime"></i>
                </div>
                <div class="exitPriceCol column">
                    <input value="'.$exitPrice.'" class="mInput" />
                </div>
                <div class="exitDateCol column">
                    <input value="'.$exitDate.'" class="mInput" />
                    <i class="fal fa-clock addTradeTime"></i>
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
                <div class="tradeChbxCol">
                    <input type="checkbox" class="tradeChbx" />
                </div>
            </div>';
        }

        $stmt->close();

    }