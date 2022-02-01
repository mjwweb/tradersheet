    <?php
        require 'tradelogForms.html';
        require 'tutorialForms.html';
    ?>


    <div class="topBar">
        <!--<button class="apiMenuTog"><i class="fal fa-bars"></i></button>-->
        <button class="refreshChartBtn"><i class="far fa-sync"></i></button>
        <button style="display: none;" class="randLogBtn">New Demo</button>
        <button id="settingsBtn"><i class="bi bi-gear"></i></button>
        <button id="addTradeBtn">Add Trade</button>

        <div class="returnChartHdrWrap">
            <p class="returnChartSpans">P&L:<span class="totalRtrn"></span></p>
            <p class="returnChartSpans">Today:<span class="dayRtrn"></span></p>
            <p class="returnChartSpans">7 day:<span class="weekRtrn"></span></p>
            <p class="returnChartSpans">30 day:<span class="monthRtrn"></span></p>
        </div>

        <button class="accountMobileSelect">
            <i class="fas fa-user-circle"></i>
        </button>
        <div id="accountDropdownWrap">
            <div class="accountDropdownInner">
                <span class="activeAccount">
                    <!-- ajax content --></span>
                <i class="bi bi-caret-down-fill accountDropdownArrow"></i>
            </div>
            <div class="accountDropdownResultsWrap">
                <div class="userAccounts">
                    <!-- ajax loaded content -->
                </div>
                <div class="addAccountBtn">
                    <i class="bi bi-plus-circle"></i>
                    <span>Add Account</span>
                </div>
            </div>
        </div>
    </div>

    <!-- main window wrap -->
    <div style="display: block; position: relative;">

        <div class="bkgTint"></div>

        <div class="apiWindow shadow">

            <div class="apiKeyWrap">
                <div style="text-align: left;">
                    <p style="display: inline-block;" class="sectionHdr">Api Key:</p>

                    <?php if (isset($_SESSION['uid'])) : ?>
                    <div class="accountSelectWrap">
                        <select class="accountSelect">
                            <option selected disabled hidden>Select Account</option>
                            <?php
                                $stmt = $conn->prepare('SELECT account_name, id FROM accounts WHERE uid=?');
                                $stmt->bind_param('i', $_SESSION['uid']);
                                $stmt->execute();
                                $stmt->bind_result($accountName, $id);
                                while ($stmt->fetch()) {
                                    echo '<option accountId="'.$id.'">'.$accountName.'</option>';
                                }
                                $stmt->close();
                            ?>
                        </select>
                    </div>
                    <?php endif; ?>

                </div>

                <?php
                    if (isset($_SESSION['uid'])) {
                        $key = 'Select a trade account';
                    } else {
                        $key = 'Login or register to get API keys';
                    }
                ?>
                <p class="codeSample accountApiKey"><?php echo $key; ?></p>
            </div>

            <div class="apiEndpointWrap">
                <p class="sectionHdr">Api Endpoint:</p>
                <p class="codeSample">https://www.mike-worden.com/tradersheet/api/?key=<span class="apiPoints">YOUR_API_KEY</span>
                </p>
            </div>

            <p class="sectionHdr">Url Parameters:</p>

            <div class="parameterSection shadow-sm">

                <div class="sectionWrap apiSortWrap">
                    <div class="parameterHdrWrap" for="apiSortContent">
                        <p class="parameterHdr">Sort</p>
                        <i class="far fa-chevron-down sectionChevron"></i>
                    </div>
                    <div class="sectionContent apiSortContent">
                        <p class="apiParamMsg">Chose the column to sort by. Default is the order you added your trades.
                            Set
                            the sort parameter equal to any of the abbreviated values below.</p>
                        <div class="codeSample columnSortValues">
                            <p>Symbol: <span>sym<span></p>
                            <p>Status: <span>sts<span></p>
                            <p>Side: <span>sde<span></p>
                            <p>Entry Date: <span>etd<span></p>
                            <p>Exit Date: <span>exd<span></p>
                            <p>Quantity: <span>qty<span></p>
                            <p>Entry Price: <span>etp<span></p>
                            <p>Exit Price: <span>exp<span></p>
                            <p>Fees: <span>fee<span></p>
                            <p>Net Return: <span>nrt<span></p>
                            <p>Roi: <span>roi<span></p>
                            <p>Entry Amount: <span>eta<span></p>
                            <p>Exit Amount: <span>exa<span></p>
                            <p>Stop Loss: <span>stl<span></p>
                            <p>Take Profit: <span>tkp<span></p>
                        </div>
                        <p class="exHdr">Request:</p>
                        <p class="codeSample">https://www.mike-worden.com/tradersheet/api/?key=YOUR_API_KEY&<span
                                class="apiPoints">sort=sym</span></p>
                    </div>
                </div>

                <div class="sectionWrap apiOrderWrap">
                    <div class="parameterHdrWrap" for="apiOrderContent">
                        <p class="parameterHdr">Order</p>
                        <i class="far fa-chevron-down sectionChevron"></i>
                    </div>
                    <div class="sectionContent apiOrderContent">
                        <p class="apiParamMsg">The order to sort the results on. Values are <span>asc</span> and
                            <span>desc</span>. Default is asc (ascending).</p>
                        <p class="exHdr">Request:</p>
                        <p class="codeSample">https://www.mike-worden.com/tradersheet/api/?key=YOUR_API_KEY&sort=sym&<span
                                class="apiPoints">order=asc</span></p>
                    </div>
                </div>

                <div class="sectionWrap apiLimitWrap">
                    <div class="parameterHdrWrap" for="apiLimitContent">
                        <p class="parameterHdr">Limit</p>
                        <i class="far fa-chevron-down sectionChevron"></i>
                    </div>
                    <div class="sectionContent apiLimitContent">
                        <p class="apiParamMsg">Specify how many trades you want returned by setting the limit paramter
                            equal
                            to any number. Leave this parameter blank if you want to return all trades.</p>
                        <p class="exHdr">Request</p>
                        <p class="codeSample">https://www.mike-worden.com/tradersheet/api/?key=YOUR_API_KEY&<span
                                class="apiPoints">limit=75</span></p>
                    </div>
                </div>

                <div class="sectionWrap apiSymbolWrap">
                    <div class="parameterHdrWrap" for="apiSymbolContent">
                        <p class="parameterHdr">Symbol</p>
                        <i class="far fa-chevron-down sectionChevron"></i>
                    </div>
                    <div class="sectionContent apiSymbolContent">
                        <p class="apiParamMsg">Specify a ticker symbol. Leave blank to query all ticker symbols.</p>
                        <p class="exHdr">Request</p>
                        <p class="codeSample">https://www.mike-worden.com/tradersheet/api/?key=YOUR_API_KEY&<span
                                class="apiPoints">symbol=tsla</span></p>
                    </div>
                </div>

                <div class="sectionWrap apiDateWrap">
                    <div class="parameterHdrWrap" for="apiDateContent">
                        <p class="parameterHdr">Dates</p>
                        <i class="far fa-chevron-down sectionChevron"></i>
                    </div>
                    <div class="sectionContent apiDateContent">
                        <p class="apiParamMsg">Specify the date of the trades returned. Works for both entry and exit
                            dates.
                            Date format must be in YYYY-MM-DD.</p>
                        <p class="exHdr">Entry Date:</p>
                        <p class="codeSample">https://www.mike-worden.com/tradersheet/api/?key=YOUR_API_KEY&<span
                                class="apiPoints">entrydate=2021-10-23</span></p>
                        <p class="exHdr">Exit Date:</p>
                        <p class="codeSample">https://www.mike-worden.com/tradersheet/api/?key=YOUR_API_KEY&<span
                                class="apiPoints">exitdate=2021-11-15</span></p>
                    </div>
                </div>

                <div class="sectionWrap apiStatusWrap">
                    <div class="parameterHdrWrap" for="apiStatusContent">
                        <p class="parameterHdr">Status</p>
                        <i class="far fa-chevron-down sectionChevron"></i>
                    </div>
                    <div class="sectionContent apiStatusContent">
                        <p class="apiParamMsg">Specify the trade status. Values are <span>open</span> and
                            <span>closed</span>. Default returns both open and closed trades.</p>
                        <p class="codeSample">https://www.mike-worden.com/tradersheet/api/?key=YOUR_API_KEY&<span
                                class="apiPoints">status=open</span></p>
                    </div>
                </div>

                <div class="sectionWrap apiSideWrap">
                    <div class="parameterHdrWrap" for="apiSideContent">
                        <p class="parameterHdr">Side</p>
                        <i class="far fa-chevron-down sectionChevron"></i>
                    </div>
                    <div class="sectionContent apiSideContent">
                        <p class="apiParamMsg">Specify the trade side. Values are <span>long</span> and
                            <span>short</span>.
                            Default returns both long and short trades.</p>
                        <p class="codeSample">https://www.mike-worden.com/tradersheet/api/?key=YOUR_API_KEY&<span
                                class="apiPoints">side=long</span></p>
                    </div>
                </div>

            </div>

            <div class="apiSampleRequestWrap">
                <p class="sectionHdr">Example Request:</p>
                <p class="rateLimitMsg">*Rate limit: 20 requests / 5 seconds</p>
                <div>
                    <button class="reqCodeType jsEx actExBtn">Javascript</button>
                    <button style="display: none;" class="reqCodeType">Node (Axios)</button>
                    <button class="reqCodeType jqEx">Jquery</button>
                </div>

                <pre class="apiJsSampleRequest prettyprint">

    let xhr = new XMLHttpRequest();
        xhr.open('GET', 'https://www.mike-worden.com/tradersheet/api/?key=YOUR_API_KEY');
        xhr.send();
        xhr.onload = function() {
        data = JSON.parse(xhr.response);
        console.log(data);
    };


</pre>

                <pre class="apiJqSampleRequest prettyprint">
    $.ajax({
        type: 'GET',
        url: 'https://www.mike-worden.com/tradersheet/api/?key=YOUR_API_KEY',
        success: function(data) {
            data = JSON.parse(data);
            console.log(data);
        }
    });

</pre>

            </div>
            <div class="apiSampleResponseWrap">
                <p class="sectionHdr">Trade Object:</p>

                <pre class="apiSampleResponse prettyprint">

    {
        "symbol": "MSFT",
        "status": "Closed",
        "side": "Long",
        "category": null,
        "entry_date": "2020-12-24",
        "exit_date": "2021-06-24",
        "quantity": "5.00000000",
        "entry_price": "50.00",
        "exit_price": "205.00",
        "fees": null,
        "net_return": "775.00",
        "roi": "310.00",
        "entry_amount": "250.00",
        "exit_amount": "1025.00",
        "stop_loss": null,
        "take_profit": null
    }
</pre>
            </div>

        </div>

        <div class="topWindowWrap">

            <!-- left side -->

            <div class="dashboardLeft">

                <div class="topTradesWrap">
                    <div class="topTradesHdrWrap">
                        <p class="recentNotesHdr">Top Trades</p>
                    </div>
                    <div class="topTradesInner">
                        <div class="topTradesInnerInner">
                            <!-- ajax loaded content -->
                        </div>
                    </div>
                </div>

                <div class="openPositionsWrap">
                    <div class="openPositionsHdrWrap">
                        <p class="openPositionsHdr">Open Positions</p>
                    </div>
                    <div class="openPositionsChartWrap">
                        <div id="openTradesChart">
                            <!-- chart data -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- middle charts -->

            <div class="returnChartsWrap">
                <div class="plChartWrap">
                    <p class="subChartHdr">Total Net Return</p>
                    <div id="pl_chart"></div>
                </div>

                <div class="subChartWrap">
                    <p class="subChartHdr">Daily Net Return</p>
                    <div id="dailyReturnChart"></div>
                </div>

                <div class="subChartWrap">
                    <p class="subChartHdr">Daily Volume</p>
                    <div id="dailyVolumeChart"></div>
                </div>

                <div class="subChartWrap">
                    <p class="subChartHdr">Total Volume</p>
                    <div id="totalVolumeChart"></div>
                </div>

                <div class="subChartWrap">
                    <p class="subChartHdr">Daily Profits Vs Losses</p>
                    <div id="dailyProfitsLossesChart"></div>
                </div>

                <div class="subChartWrap">
                    <p class="subChartHdr">Total Profits Vs Losses</p>
                    <div id="totalProfitsLossesChart"></div>
                </div>
            </div>

            <!-- right key metrics -->

            <div class="keyMetricSection">
                <div class="tradeCount keyMetric">Trades: <span></span></div>
                <div class="avgTradeRtrn keyMetric">Avg Trade Return: <span></span></div>
                <div class="winsCount keyMetric">Wins: <span class="greenCol"></span></div>
                <div class="lossesCount keyMetric">Losses: <span class="redCol"></span></div>
                <div class="wlRatio keyMetric">W/L Ratio: <span></span></div>
                <div class="totalGains keyMetric">Total Profits: <span class="greenCol"></span></div>
                <div class="totalLosses keyMetric">Total Losses: <span class="redCol"></span></div>
                <div class="totalVolume keyMetric">Total Volume <span></span></div>
                <div class="longVolume keyMetric">Long Volume <span class="greenCol"></span></div>
                <div class="shortVolume keyMetric">Short Volume <span class="redCol"></span></div>
                <p class="keyMetricMsg">More key metrics coming soon.</p>
                <!--<div class="shareVolume keyMetric">Share Volume <span></span></div>-->
                <!--<div class="epsMetric keyMetric">EPS <span></span></div>-->
            </div>

        </div>


        <div class="bottomWindowWrap">
            <div class="tradeLogWrapper">

                <div class="tradeLogHdr">
                    <div class="tradeLogHdrDflt">
                        <!--
                        <button class="spreadsheetBtn logTogBtns actLogBtn">Spreadsheet</button>
                        <button class="openTradesBtn logTogBtns">Open</button>
                        <button class="closedTradesBtn logTogBtns">Closed</button>
                        -->

                        <div class="srchSymWrap">
                            <div class="srchSymInner">

                                <div class="srchSymBox">
                                    <div>
                                        <i class="bi bi-search"></i>
                                        <input type="search" class="srchSymInpt" placeholder="Filter by symbol..." />
                                    </div>
                                    <div class="srchSymBottom">
                                        <div class="srchSymRslts">
                                            <!-- ajax content -->
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="tradeLogHdrRight">
                            <button class="deleteTradesBtn"></button>
                            <button class="ssFullscreenBtn"><i class="bi bi-arrows-fullscreen"></i></button>
                        </div>

                    </div>

                    <div class="tradeLogHdrErrs">
                        <button class="errLogBack"><i class="fad fa-arrow-alt-circle-left"></i></button>
                        <div class="tradeLogHdrRight">
                            <button class="deleteTradesBtn"></button>
                        </div>
                    </div>

                </div>

                <div class="tradeLogSheet">
                    <div class="tradeLogSheetInner">

                    </div>
                </div>
            </div>
        </div>


        <!--<div class="chartTopBar">P&L History</div>-->

        <?php
            if ($_SERVER['REMOTE_ADDR'] == '::1' || $_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
                $local = true;
            } else {
                $local = false;
            }

            if ($local == false && $_SESSION['account_status'] == 'new_user') {
                //require 'new-subscription-overlay.php';
            }
        ?>

        <script src="js/onload.js"></script>
        <script src="js/ajax.js"></script>
        <script src="js/eventListeners.js"></script>
        <script src="js/functions.js"></script>
        <script src="js/charts.js"></script>
        <script src="js/tradeNotes.js"></script>
        <script src="js/spreadsheet-symbol-filter.js"></script>
        <script src="js/account-dropdown.js"></script>
        <script src="js/spreadsheet.js"></script>
        <script src="js/animations.js"></script>
        <script src="js/recent-notes.js"></script>
        <script src="js/dashboard-load.js"></script>
        <script src="js/trade-data-window.js"></script>
        <script src="js/tutorial.js"></script>
        <script src="js/addTrade.js"></script>
        <script src="js/charts/dailyVolumeChart.js"></script>
        <script src="js/charts/totalVolumeChart.js"></script>
        <script src="js/charts/totalReturn.js"></script>
        <script src="js/charts/dailyReturn.js"></script>
        <script src="js/charts/dailyProfitsLosses.js"></script>
        <script src="js/charts/totalProfitsLosses.js"></script>
        <script src="js/apiDocs.js"></script>