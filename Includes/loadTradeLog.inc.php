<?php

    session_start();

    if (isset($_SESSION['uid']) && isset($_SESSION['account_id'])) {

        require 'dbh.inc.php';

        $symbol = $_POST['symbol'];
        $start = $_POST['start'];
        $limit = $_POST['limit'];
    
        if (empty($symbol)) {
            $stmt = $conn->prepare('SELECT id, symbol, category, status, side, entry_date, exit_date, quantity, entry_price, exit_price, fees, net_return, net_roi, entry_amount, exit_amount, stop_loss, take_profit FROM trades 
            WHERE uid=? AND account_id=? ORDER BY sortId, id DESC LIMIT '.$start.', '.$limit.' ');
            $stmt->bind_param('ii', $_SESSION['uid'], $_SESSION['account_id']);
        } else {
            $stmt = $conn->prepare('SELECT id, symbol, category, status, side, entry_date, exit_date, quantity, entry_price, exit_price, fees, net_return, net_roi, entry_amount, exit_amount, stop_loss, take_profit FROM trades 
            WHERE uid=? AND account_id=? AND symbol=? ORDER BY sortId, id LIMIT '.$start.', '.$limit.' ');
            $stmt->bind_param('iis', $_SESSION['uid'], $_SESSION['account_id'], $symbol);
        }
        $stmt->execute();
        $stmt->bind_result($id, $symbol, $category, $status, $side, $entryDate, $exitDate, $qty, $entryPrice, $exitPrice, $fees, $netReturn, $roi, $entryAmt, $exitAmt, $stopLoss, $takeProfit);
    
        if ($start == 0) {
        echo '
            <div class="tradeLogLabels tradeLogRow spreadsheetTradeLabels">
                <div class="tlLabelCol rowNumCol">

                </div>
                <div class="tlLabelCol noteBtnCol" column="disabled">

                </div>
                <div class="tlLabelCol statusCol" column="status">
                    <span>Status</span>
                    <div class="orderIconsWrap"><i class="bi bi-chevron-expand"></i></div>
                </div>
                <div class="tlLabelCol categoryCol" column="category">
                    <span>Sector</span>
                    <div class="orderIconsWrap"><i class="bi bi-chevron-expand"></i></div>
                </div>
                <div class="tlLabelCol symbolCol" column="symbol">
                    <span>Symbol</span>
                    <div class="orderIconsWrap"><i class="bi bi-chevron-expand"></i></div>
                </div>
                <div class="tlLabelCol sideLabel sideCol" column="side">
                    <span>Side</span>
                    <div class="orderIconsWrap"><i class="bi bi-chevron-expand"></i></div>
                </div>
                <div class="tlLabelCol qtyLabel qtyCol" column="quantity">
                    <span>Qty</span>
                    <div class="orderIconsWrap"><i class="bi bi-chevron-expand"></i></div>
                </div>
                <div class="tlLabelCol boughtLabel entryPriceCol" column="entry_price">
                    <span>Entry Price</span>
                    <div class="orderIconsWrap"><i class="bi bi-chevron-expand"></i></div>
                </div>
                <div class="tlLabelCol entryDateLabel entryDateCol" column="entry_date">
                    <span>Entry Date</span>
                    <div class="orderIconsWrap"><i class="bi bi-chevron-expand"></i></div>
                </div>
                <div class="tlLabelCol soldLabel exitPriceCol" column="exit_price">
                    <span>Exit Price</span>
                    <div class="orderIconsWrap"><i class="bi bi-chevron-expand"></i></div>
                </div>
                <div class="tlLabelCol exitDateLabel exitDateCol" column="exit_date">
                    <span>Exit Date</span>
                    <div class="orderIconsWrap"><i class="bi bi-chevron-expand"></i></div>
                </div>
                <div class="tlLabelCol openStopLabel stopLossCol" column="stop_loss">
                    <span>Stop Loss</span>
                    <div class="orderIconsWrap"><i class="bi bi-chevron-expand"></i></div>
                </div>
                <div class="tlLabelCol openTakeLabel takeProfitCol" column="take_profit">
                    <span>Take Profit</span>
                    <div class="orderIconsWrap"><i class="bi bi-chevron-expand"></i></div>
                </div>
                <div class="tlLabelCol feeLabel feeCol" column="fees">
                    <span>Fees</span>
                    <div class="orderIconsWrap"><i class="bi bi-chevron-expand"></i></div>
                </div>

                <!--
                <div class="tlLabelCol boughtLabel entryAmtCol" column="entry_amount">
                    <span>Entry Amt</span>
                    <div class="orderIconsWrap"><i class="bi bi-chevron-expand"></i></div>
                </div>
                <div class="tlLabelCol soldLabel exitAmtCol" column="exit_amount">
                    <span>Exit Amt</span>
                    <div class="orderIconsWrap"><i class="bi bi-chevron-expand"></i></div>
                </div>
                -->

                <div class="tlLabelCol netReturnLabel netReturnCol" column="net_return">
                    <span>Net Return</span>
                    <div class="orderIconsWrap"><i class="bi bi-chevron-expand"></i></div>
                </div>
                <div class="tlLabelCol netRoiLabel netRoiCol" column="net_roi">
                    <span>Net Roi</span>
                    <div class="orderIconsWrap"><i class="bi bi-chevron-expand"></i></div>
                </div>
                <div class="tradeInfoCol">

                </div>
                <div class="tlLabelCol tradeChbxCol" column="disabled">

                </div>
            </div>';
        }

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
            <div class="tradeLogDataRow tradeLogRow spreadsheetRow" id="'.$id.'" symbol="'.$symbol.'">
                <div class="rowNumCol column">
                    <span></span>
                </div>
                <div class="noteBtnCol column">
                <i class="bi bi-sticky showTradeNotes"></i>
                </div>
                <div class="statusCol column">
                    <input value="'.$status.'" disabled class="disabledInpt mInput '.$statusClass.' " />
                </div>
                <div class="categoryCol column">
                    <input value="'.$category.'" class="mInput" />
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

                <!--
                <div class="entryAmtCol column">
                    <input disabled value="'.$entryAmt.'" class="disabledInpt mInput" />
                </div>
                <div class="exitAmtCol column">
                    <input disabled value="'.$exitAmt.'" class="disabledInpt mInput" />
                </div>
                -->

                <div class="netReturnCol column">
                    <input disabled value="'.$netReturn.'" class="disabledInpt mInput '.$returnClass.'" />
                </div>
                <div class="netRoiCol column">
                    <input disabled value="'.$roi.'" class="disabledInpt mInput '.$roiClass.'" />
                </div>
                <div class="tradeInfoCol">
                    <i symbol="'.$symbol.'" class="bi bi-graph-up-arrow"></i>
                </div>
                <div class="tradeChbxCol column">
                    <input type="checkbox" class="tradeChbx" />
                </div>
            </div>';
        }
    
        $stmt->close();

    }