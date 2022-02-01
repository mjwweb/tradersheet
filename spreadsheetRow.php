

        <div class="tradeLogDataRow tradeLogRow" id="<?php echo uniqid('', true);?>">
            <div class="noteBtnCol">
                <i class="fal fa-comment-alt-lines showTradeNotes"></i>
            </div>
            <div class="statusCol">
                <input disabled class="disabledInpt mInput '.$statusClass.' " />
            </div>
            <div class="symbolCol column">
                <input class="mInput" />
            </div>
            <div class="sideCol column">
                <input readonly="readonly" value="Long" class="mInput" />
            </div>
            <div class="qtyCol column">
                <input class="mInput" />
            </div>
            <div class="entryPriceCol column">
                <input class="mInput" />
            </div>
            <div class="entryDateCol column">
                <input class="mInput" />
            </div>
            <div class="exitPriceCol column">
                <input class="mInput" />
            </div>
            <div class="exitDateCol column">
                <input class="mInput" />
            </div>
            <div class="stopLossCol">
                <input type="text" class="mInput" />
            </div>
            <div class="takeProfitCol">
                <input type="text" class="mInput" />
            </div>
            <div class="feeCol column">
                <input class="mInput" />
            </div>
            <div class="entryAmtCol column">
                <input class="disabledInpt mInput" />
            </div>
            <div class="exitAmtCol column">
                <input class="disabledInpt mInput" />
            </div>
            <div class="netReturnCol column">
                <input disabled class="disabledInpt mInput" />
            </div>
            <div class="netRoiCol column">
                <input disabled class="disabledInpt mInput" />
            </div>
            <div class="tradeChbxCol">
                <input type="checkbox" class="tradeChbx" />
            </div>
        </div>