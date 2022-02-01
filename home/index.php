    <?php
        require 'header.php';
        session_start();
    ?>

    <div class="main">
        <div class="hpNav">
            <div class="navControls">
                <img class="hpLogo" src="img/dtlLogo.png" /><span
                    style="color: gray; font-size: 22px; font-family: 'Poppins', sans-serif; margin-top: 3px; margin-right; 55px;"><span>
                        <!--<button class="navBtns">Home</button>-->
                        <button style="margin-left: 25px;" class="navBtns apiNavBtn">API Reference</button>
                        <button class="navBtns supportNavBtn">Support</button>
            </div>
            <div class="authBtnsNav">
                <?php if (!isset($_SESSION['uid'])) : ?>
                <button class="loginBtn">Sign In</button>
                <button class="registerBtn">Register</button>
                <?php else : ?>
                <button class="dashboardBtn">Dashboard</button>
                <?php endif ; ?>
            </div>
        </div>

        <div class="heroSection">
            <div class="heroSectionInner innerSec">
                <div class="row">
                    <div class="col-12 col-lg-4 align-self-center heroSectionLeft">
                        <h1>Free Trading Journal</h1>
                        <p class="heroMsg">Log past trades, track performance across your portfolio, and build your own trade analytics by connecting to our easy to use API service.</p>
                        <div class="authBtnsHero">
                            <?php if (!isset($_SESSION['uid'])) : ?>
                            <button class="loginBtn">Sign In</button>
                            <button class="registerBtn">Register</button>
                            <?php else : ?>
                            <button class="dashboardBtn">Dashboard</button>
                            <?php endif ; ?>
                        </div>
                    </div>

                    <div class="col-12 col-lg-8 heroSectionRight">
                        <img style="min-width: 100%;" class="img-fluid align-self-center laptop_img"
                            src="img/laptop_dark.png" />
                    </div>
                </div>
            </div>
        </div>

        <div class="introSec">
            <div class="introSecInner innerSec">
                <h2 class="introSecHdr mb-5">Getting Started</h2>

                <div class="row introSecBoxWrap">
                    <div class="col-12 col-md-4">
                        <div class="introSecBox shadow">
                            <i class="bi bi-card-list"></i>
                            <h3 class="introBoxHdr">Log Trades</h3>
                            <p class="introBoxMsg">Easily add in new trades and edit them later in our spreadsheet.</p>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="introSecBox shadow">
                            <i class="bi bi-activity"></i>
                            <h3 class="introBoxHdr">Track Performance</h3>
                            <p class="introBoxMsg">Use our built in dashboard to track your returns and more.</p>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="introSecBox shadow">
                            <i class="bi bi-bar-chart-line"></i>
                            <h3 class="introBoxHdr">Start Building</h3>
                            <p class="introBoxMsg">Connect to our API and start building your own projects.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="features-section">
            <div class="features-inner innerSec">
                <h2 class="featuresHdr">Features</h2>
                <div class="row">
                    <div class="col-6 col-lg-4 feature-box">
                        <i class="bi bi-table" style="color: purple;"></i>
                        <div class="feature-content">
                            <h3>Spreadsheet</h3>
                            <p>Easily add in new trades and edit them with our spreadsheet. Prebuilt forumlas
                                calculate your ROI and Net Return on each of your trades.
                            </p>
                        </div>
                    </div>
                    <div class="col-6 col-lg-4 feature-box">
                        <i class="bi bi-key" style="color: #1e90ff;"></i>
                        <div class="feature-content">
                            <h3>Key Metrics</h3>
                            <p>Get automated metrics from your entire trade history. View your average trade return, win
                                /
                                loss ratio, trade volume, and other useful metrics from your portfolio.</p>
                        </div>
                    </div>
                    <div class="col-6 col-lg-4 feature-box">
                        <i class="bi bi-graph-up" style="color: orange;"></i>
                        <div class="feature-content">
                            <h3>History Charts</h3>
                            <p>Track your accumulated and daily P&L, trade volume, and profits vs. losses. Our synced
                                charts
                                allow you to compare these values at any time period.</p>
                        </div>
                    </div>
                    <div class="col-6 col-lg-4 feature-box">
                        <i class="bi bi-card-list" style="color: green;"></i>
                        <div class="feature-content">
                            <h3>Trade Notes</h3>
                            <p>Make notes about your trades, and review them later. Enter them during the trading day,
                                or wait until later – you get to decide for yourself how much you want to do during the
                                trading day.</p>
                        </div>
                    </div>
                    <div class="col-6 col-lg-4 feature-box">
                        <i class="bi bi-sort-alpha-up" style="color: skyblue;"></i>
                        <div class="feature-content">
                            <h3>Trade Sorting</h3>
                            <p>Sort through your trade history by date, net return, ROI, trade side, sector, and more. You can also
                                filter by symbol, and then sort trades by the given symbol.</p>
                        </div>
                    </div>
                    <div class="col-6 col-lg-4 feature-box">
                        <i class="bi bi-link-45deg" style="color: teal;"></i>
                        <div class="feature-content">
                            <h3>API Endpoint</h3>
                            <p>Connect to your trade account through our easy to use API services. Build your own
                                analytics
                                with your preferred programming languages.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--
        <section class="randSec">
            <div class="innerSec">

                <div class="row text-left align-items-center spreadsheet-sec">
                    <div class="col-12 col-md-5">
                        <img alt="image" class="img-fluid" src="img/spreadsheet.svg">
                    </div>

                    <div class="col-12 col-md-5 offset-md-2">
                        <h2 class="mb-3"><strong>In-Built Spreadsheet</strong></h2>
                        <p class="lead">Even the all-powerful Pointing has no control about the blind texts it is an
                            almost unorthographic life</p>
                        <div class="featureChecksWrap">
                            <div class="featureChecksRow">
                                <i class="far fa-check featureCheck"></i>
                                <span>Net Return and ROI on every trade</span>
                            </div>
                            <div class="featureChecksRow">
                                <i class="far fa-check featureCheck"></i>
                                <span>Individual trade notes</span>
                            </div>
                            <div class="featureChecksRow">
                                <i class="far fa-check featureCheck"></i>
                                <span>Column and symbol sorting</span>
                            </div>
                            <div class="featureChecksRow">
                                <i class="far fa-check featureCheck"></i>
                                <span>Stop losses and take profits</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row text-left align-items-center pt-5">
                    <div class="col-12 col-md-5 offset-md-2 m-md-auto order-md-5">
                        <img alt="image" class="img-fluid" src="img/charts.svg">
                    </div>

                    <div class="col-12 col-md-5">
                        <h2 class="mb-3"><strong>Automated Performace</strong></h2>
                        <p class="lead">Even the all-powerful Pointing has no control about the blind texts it is an
                            almost unorthographic life</p>
                        <div class="featureChecksWrap">
                            <div class="featureChecksRow">
                                <i class="far fa-check featureCheck"></i>
                                <span>Unlimited brokerage accounts</span>
                            </div>
                            <div class="featureChecksRow">
                                <i class="far fa-check featureCheck"></i>
                                <span>Return history vs daily return charts</span>
                            </div>
                            <div class="featureChecksRow">
                                <i class="far fa-check featureCheck"></i>
                                <span>Daily, 30 day, and 90 day returns</span>
                            </div>
                            <div class="featureChecksRow">
                                <i class="far fa-check featureCheck"></i>
                                <span>Win / Loss ratio and more key metrics</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row text-left align-items-center pt-5 mb-5">
                    <div class="col-12 col-md-5">
                        <img alt="image" class="img-fluid" src="img/developer.svg">
                    </div>

                    <div class="col-12 col-md-5 offset-md-2">
                        <h2 class="mb-3"><strong>Log your trades</strong></h2>
                        <p class="lead">Even the all-powerful Pointing has no control about the blind texts it is an
                            almost unorthographic life</p>
                        <div class="featureChecksWrap">
                            <div class="featureChecksRow">
                                <i class="far fa-check featureCheck"></i>
                                <span>Lorem Ipsum dolor sit amet</span>
                            </div>
                            <div class="featureChecksRow">
                                <i class="far fa-check featureCheck"></i>
                                <span>Lorem Ipsum dolor sit amet</span>
                            </div>
                            <div class="featureChecksRow">
                                <i class="far fa-check featureCheck"></i>
                                <span>Lorem Ipsum dolor sit amet</span>
                            </div>
                            <div class="featureChecksRow">
                                <i class="far fa-check featureCheck"></i>
                                <span>Lorem Ipsum dolor sit amet</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <div class="keyMetricSection">
            <div class="innerSec keyMetricsInnerSec">
                <h2>Portfolio Metrics</h2>

                <div class="row metricRow">
                    <div class="col-6 col-md-4">
                        <div class="keyMetric"">
                            <i class=" fas fa-hashtag" style="background: #35bfe7;"></i>
                            <p class="metricTitle">Total Trades</p>
                            <p class="metricDescrip">Number of trades made</p>
                        </div>
                    </div>
                    <div class="col-6 col-md-4">
                        <div class="keyMetric"">
                            <i class=" fas fa-thumbs-up" style="background: #90ee90;"></i>
                            <p class="metricTitle">Wins</p>
                            <p class="metricDescrip">Trade count with profit</p>
                        </div>
                    </div>
                    <div class="col-6 col-md-4">
                        <div class="keyMetric"">
                            <i class=" fas fa-thumbs-down" style="background: #DB4437;"></i>
                            <p class="metricTitle">Losses</p>
                            <p class="metricDescrip">Trade count with losses</p>
                        </div>
                    </div>
                    <div class="col-6 col-md-4"">
                        <div class=" keyMetric">
                        <i class="fas fa-chart-line" style="background: #90ee90;"></i>
                        <p class="metricTitle">Total Gains</p>
                        <p class="metricDescrip">Profits accumulated</p>
                    </div>
                </div>
                <div class="col-6 col-md-4"">
                        <div class=" keyMetric">
                    <i class="fas fa-chart-line-down" style="background: #DB4437;"></i>
                    <p class="metricTitle">Total Losses</p>
                    <p class="metricDescrip">Losses accumulated</p>
                </div>
            </div>
            <div class="col-6 col-md-4">
                <div class="keyMetric"">
                            <i class=" fas fa-percentage" style="background: purple;"></i>
                    <p class="metricTitle">W/L Ratio</p>
                    <p class="metricDescrip">Total wins / losses</p>
                </div>
            </div>
        </div>

    </div>
    </div>
    
        <div class="spreadsheetSec">
            <div class="spreadsheetInnerSec innerSec">
                <div class="spreadsheetSecContent">
                    <div class="spreadsheetDescripWrap">
                        <h2>Integrated Spreadsheet</h2>
                        <p class="spreadsheetMsg">Log thousands of trades without losing software performance.
                            Enter your trade data and your net return, roi, and portfolio
                            metrics
                            are automatically calculated. All changes you make are automatically saved to our
                            database that you have access to through our api services.</p>
                    </div>
                    <div class="spreadsheetImgWrap">
                        <img src="img/ss-capture.JPG" />
                    </div>
                </div>

            </div>
        </div>
        -->

        <div class="apiSection">
            <div class="apiSecInner innerSec">
                <div class="row">
                    <div class="col-12 col-md-5 col-lg-6 apiInfoWrap">
                        <h2>Built for developers</h2>
                        <p class="apiMsg">Convert your spreadsheet data into JSON by connecting
                            to our easy to use api services. Create your own charts, key metrics, and interactive
                            dashboards
                            using your prefered programing languages and frameworks. For building your own charts, we
                            recomend using using
                            <a href="https://www.apexcharts.com">apex charts</a>. For free live stock and crypto prices,
                            we
                            recommend connecting through <a href="https://www.polygon.io">Polygon.io</a>.</p>
                        <p class="apiEndpointHdr">Url Endpoint:</p>
                        <p class="apiEndpoint shadow-sm">https://mike-worden.com/api/?key=<span
                                style="color: #1e90ff;">YOUR_API_KEY</span></p>
                        <button class="apiUsageBtn">Api Reference</button>
                        <!--<button class="discordBtn"><i class="fab fa-discord"></i> Join Discord</button>-->
                    </div>
                    <div class="d-xs-none col-md-7 col-lg-4 offset-lg-2 apiObjectWrap">
                        <!--<p class="tradeObjectHdr">Trade Object:</p>-->
                        <pre class="tradeObject prettyprint shadow">

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
            </div>
        </div>

        <div class="featuresSection">
            <div class="featuresSectionInner innerSec">

                <h2 class="featuresHdr">API Features</h2>
                <!--<p class="featuresHdrMsg">Start creating your own projects today.</a></p>-->

                <div class="row featuresRow">

                    <div class="col-4 apiFeatureWrap keysapiFeatureWrap">
                        <div class="apiFeatureIcon" style="background-image: linear-gradient(to top left, rgb(41, 133, 255), rgba(41, 133, 255, .8));">
                            <i class="bi bi-key-fill"></i>
                        </div>
                        <p class="featureHdr">Api Keys</p>
                        <p class="featureMsg">Api keys for each Brokerage account</p>
                    </div>

                    <div class="col-4 apiFeatureWrap chartFeaturesWrap">
                        <div class="apiFeatureIcon" style="background-image: linear-gradient(to top left, rgb(240, 128, 128), rgba(240, 128, 128, .8));">
                            <i class="bi bi-bar-chart-fill"></i>
                        </div>
                        <p class="featureHdr">Chart Library</p>
                        <p class="featureMsg">Free chart library with <a href="https://www.apexcharts.com">apex charts</a>
                        </p>
                    </div>

                    <div class="col-4 apiFeatureWrap pricesapiFeatureWrap">
                        <div class="apiFeatureIcon" style="background-image: linear-gradient(to top left, rgb(144, 238, 144), rgba(144, 238, 144, .8));">
                            <i class="bi bi-currency-dollar"></i>
                        </div>
                        <p class="featureHdr">Live Prices</p>
                        <p class="featureMsg">Connect to <a href="https://www.polygon.io">polygon for live prices</a></p>
                    </div>

                </div>

                <div class="githubBtnWrap">
                    <button class="githubBtn">
                        <i class="fab fa-github"></i>
                        Repository
                    </button>
                </div>

            </div>
        </div>

        <div class="tradingViewSection altBkg">
            <div class="tradingViewInner innerSec">
                <div class="row">
                    <div class="col-12 col-lg-4 align-self-center">
                        <h1>Trading View Charts</h1>
                        <p class="heroMsg">View live stock prices and indicators directly from your spreadsheet. Just click the chart icon next to one of your trades. No need to switch browser tabs to get updated stock prices.</p>
                    </div>

                    <div class="col-12 col-lg-7 offset-lg-1">
                        <!-- TradingView Widget BEGIN -->
                        <div style="width: 100%;" class="tradingview-widget-container">
                            <div id="tradingview_2b577"></div>
                            <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
                            <script type="text/javascript">
                                new TradingView.widget({
                                    "height": 500,
                                    "symbol": "NASDAQ:AAPL",
                                    "interval": "D",
                                    "timezone": "Etc/UTC",
                                    "theme": "dark",
                                    "style": "1",
                                    "locale": "en",
                                    "toolbar_bg": "#f1f3f6",
                                    "enable_publishing": false,
                                    "allow_symbol_change": true,
                                    "container_id": "tradingview_2b577"
                                });
                            </script>
                        </div>
                        <!-- TradingView Widget END -->
                    </div>
                </div>
            </div>
        </div>

        <!--

    <div class="chartsSection altBkg">
        <div class="chartsInnerSec innerSec">
            <h2>Return charts</h2>
            <p class="chartsMsg">Overall net return and daily return charts are automatically updated when your
                done
                making changes to your spreadsheet. Easily track your returns over any time period.</p>
            <div class="chartsWrap shadow-lg">
                <div class="returnChartHdrWrap">
                    <h3 class="returnChartHdr">Net Return History</h3>
                    <p class="returnChartHdr">Total:<span class="totalRtrn"> $51,345</span></p>
                    <p class="returnChartHdr">24 hr:<span class="dayRtrn"> $-498</span></p>
                    <p class="returnChartHdr">7 day:<span class="weekRtrn"> $6,813</span></p>
                    <p class="returnChartHdr">30 day:<span class="monthRtrn"> $11,487</span></p>
                </div>
                <div class="return_chart"></div>
                <div class="daily_chart"></div>
            </div>
        </div>
    </div>

    <div class="apiChartSampleSection">
        <div class="apiChartSampleInner innerSec">

            <div class="apiChartRow">
                <div class="apiChartWrap">

                </div>
                <div class="apiChartWrap">

                </div>
            </div>

            <div class="apiChartRow">
                <div class="apiChartWrap">

                </div>
                <div class="apiChartWrap">

                </div>
            </div>

        </div>
    </div>

    <div class="tradeNotesSection" style="display: none;">
        <div class="innerSec tradeNotesInnerSec">

            <div class="tradeNotesContent">
                <div class="tradeNotesInfoWrap">
                    <h2>Trade Notes</h2>
                    <p class="tradeNotesMsg">testing 123</p>
                </div>
                <div class="tradeNotesImgWrap">
                    <img src="img/tradeNotes.jpg" />
                </div>
            </div>

        </div>
    </div>
    -->

        <div class="footer">
            <div class="innerSec footerInnerSec">
                <div class="footerContent">
                <img class="footerLogo" src="img/dtlLogo.png" />
                    <!--
                    <button class="footerBtn footerPrivacy">Privacy Policy</button>
                    <button class="footerBtn footerTerms">Terms of use</button>
                    <button class="footerBtn footerCookie">Cookie Policy</button>
                    -->
                    <button class="footerBtn footerSupport">Support</button>
                    <button class="footerBtn footerApi">Api Reference</button>
                </div>
            </div>
        </div>

    </div>

    <div class="mobileLp">

        <img class="hpLogoMobile" src="img/dtlLogo.png" />

        <p class="mobileMsg">Mobile site coming soon</p>

    </div>

    <script>
        var local = false;

        if (location.hostname === "localhost" || location.hostname === "127.0.0.1") {
            local = true;
        }

        $('.footerPrivacy').click(function () {
            if (local == true) {
                window.location.href = 'http://localhost/tradersheet/privacy';
            } else {
                window.location.href = 'https://www.mike-worden.com/tradersheet/privacy';
            }
        });

        $('.footerTerms').click(function () {
            if (local == true) {
                window.location.href = 'http://localhost/tradersheet/terms';
            } else {
                window.location.href = 'https://www.mike-worden.com/tradersheet/terms';
            }
        });

        $('.footerCookie').click(function () {
            if (local == true) {
                window.location.href = 'http://localhost/tradersheet/cookiepolicy';
            } else {
                window.location.href = 'https://www.mike-worden.com/tradersheet/cookiepolicy';
            }
        });

        $('.loginBtn').click(function () {
            if (local == true) {
                window.location.href = 'http://localhost/tradersheet/auth/?login';
            } else {
                window.location.href = 'https://www.mike-worden.com/tradersheet/auth/?login';
            }
        });

        $('.registerBtn').click(function () {
            if (local == true) {
                window.location.href = 'http://localhost/tradersheet/auth/?register';
            } else {
                window.location.href = 'https://www.mike-worden.com/tradersheet/auth/?register';
            }
        });

        $('.dashboardBtn').click(function () {
            if (local == true) {
                window.location.href = 'http://localhost/tradersheet/';
            } else {
                window.location.href = 'https://www.mike-worden.com/tradersheet';
            }
        });

        $('.apiUsageBtn, .apiNavBtn, .footerApi').click(function () {
            if (local == true) {
                window.location.href = 'http://localhost/tradersheet/api';
            } else {
                window.location.href = 'https://www.mike-worden.com/tradersheet/api';
            }
        });

        $('.supportNavBtn, .footerSupport').click(function () {
            if (local == true) {
                window.location.href = 'http://localhost/tradersheet/support';
            } else {
                window.location.href = 'https://www.mike-worden.com/tradersheet/support';
            }
        });

        /*
        $('body').overlayScrollbars({
            callbacks: {
                onScroll: function (eventArgs) {
                    bodyScroll();
                }
            }
        });
        */

        $(window).scroll(function () {
            scrollPos = $(window).scrollTop();

            if (scrollPos > 2) {
                if (!$('.hpNav').hasClass('navScroll')) {
                    $('.hpNav').addClass('navScroll');
                }
            } else {
                $('.hpNav').removeClass('navScroll');
            }
        });

    </script>