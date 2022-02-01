<?php
    session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Tradersheet | API</title>
    <link rel="icon" type="image/png" href="../icons/favicon.png" />
    <meta charset="utf-8">
    <meta name="description"
        content="Connect to your trade accounts through our API services. Create your own analytics, connect to live prices, create custom charts and much more.">
    <meta name=viewport content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../nice-select/css/nice-select.css">
    <link rel="stylesheet/less" type="text/css" href="styles.less">
    <link type="text/css" href="../scrollbars/css/OverlayScrollbars.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;500;700&display=swap"
        rel="stylesheet">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/gh/google/code-prettify@master/loader/run_prettify.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.1/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"
        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/less.js/3.9.0/less.min.js"></script>
    <script type="text/javascript" src="../scrollbars/js/jquery.overlayScrollbars.js"></script>
    <script src="../nice-select/js/jquery.nice-select.js"></script>

</head>

<body style="font-family: 'Roboto', sans-serif;">

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
            <p class="codeSample">https://www.mike-worden.com/tradersheet/api/?key=<span class="apiPoints">YOUR_API_KEY</span></p>
        </div>

        <p class="sectionHdr">Url Parameters:</p>

        <div class="parameterSection shadow-sm">

            <div class="sectionWrap apiSortWrap">
                <div class="parameterHdrWrap" for="apiSortContent">
                    <p class="parameterHdr">Sort</p>
                    <i class="bi bi-chevron-down sectionChevron"></i>
                </div>
                <div class="sectionContent apiSortContent">
                    <p class="apiParamMsg">Chose the column to sort by. Default is the order you added your trades. Set
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
                    <i class="bi bi-chevron-down sectionChevron"></i>
                </div>
                <div class="sectionContent apiOrderContent">
                    <p class="apiParamMsg">The order to sort the results on. Values are <span>asc</span> and
                        <span>desc</span>. Default is desc (descending).</p>
                    <p class="exHdr">Request:</p>
                    <p class="codeSample">https://www.mike-worden.com/tradersheet/api/?key=YOUR_API_KEY&sort=sym&<span
                            class="apiPoints">order=asc</span></p>
                </div>
            </div>

            <div class="sectionWrap apiLimitWrap">
                <div class="parameterHdrWrap" for="apiLimitContent">
                    <p class="parameterHdr">Limit</p>
                    <i class="bi bi-chevron-down sectionChevron"></i>
                </div>
                <div class="sectionContent apiLimitContent">
                    <p class="apiParamMsg">Specify how many trades you want returned by setting the limit paramter equal
                        to any number. Leave this parameter blank if you want to return all trades.</p>
                    <p class="exHdr">Request</p>
                    <p class="codeSample">https://www.mike-worden.com/tradersheet/api/?key=YOUR_API_KEY&<span
                            class="apiPoints">limit=75</span></p>
                </div>
            </div>

            <div class="sectionWrap apiSymbolWrap">
                <div class="parameterHdrWrap" for="apiSymbolContent">
                    <p class="parameterHdr">Symbol</p>
                    <i class="bi bi-chevron-down sectionChevron"></i>
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
                    <i class="bi bi-chevron-down sectionChevron"></i>
                </div>
                <div class="sectionContent apiDateContent">
                    <p class="apiParamMsg">Specify the date of the trades returned. Works for both entry and exit dates.
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
                    <i class="bi bi-chevron-down sectionChevron"></i>
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
                    <i class="bi bi-chevron-down sectionChevron"></i>
                </div>
                <div class="sectionContent apiSideContent">
                    <p class="apiParamMsg">Specify the trade side. Values are <span>long</span> and <span>short</span>.
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

    <script>
        // account select

        $('.accountSelect').niceSelect();

        $('.accountSelect').change(function () {
            accountId = $(this).find(':selected').attr('accountId');

            $.ajax({
                type: 'POST',
                url: '../Includes/fetchApiKey.inc.php',
                data: {
                    id: accountId
                },
                success: function (data) {
                    $('.accountApiKey').text(data);
                }
            });
        });

        //javascript / jquery code sample toggle

        $('.reqCodeType').click(function () {
            $('.reqCodeType').removeClass('actExBtn');
            $(this).addClass('actExBtn');

            if ($(this).hasClass('jqEx')) {
                $('.apiJsSampleRequest').hide();
                $('.apiJqSampleRequest').show();
            } else {
                $('.apiJqSampleRequest').hide();
                $('.apiJsSampleRequest').show();
            }
        });

        // parameter section toggle

        $('.parameterHdrWrap').click(function () {
            section = $(this).attr('for');
            $('.' + section).slideToggle('fast');
            $(this).find('.sectionChevron').toggleClass('bi-chevron-down bi-chevron-up');
            $(this).toggleClass('parameterHdrOpen');
        });

        // overlay scrollbars

        $(document).ready(function () {
            $('.columnSortValues').overlayScrollbars({});
            $('body').overlayScrollbars({});
        });
    </script>