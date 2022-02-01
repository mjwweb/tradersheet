
    mainDashboardLoad('render');
    fetchOpenPositions('render');
    loadTopTrades();

function updateDashboard() {
    mainDashboardLoad('update');
    loadTopTrades();
    fetchOpenPositions('update');
}

function mainDashboardLoad(method) {
    $('.refreshChartBtn').hide();
    today = new Date();
    curDate = formatDate(today);

    $.ajax({
        type: 'POST',
        url: 'Includes/main-dashboard-query.inc.php',
        data: {
            curDate: curDate
        },
        success: function (data) {

            //reset chart data arrays
            returnChartData = [];
            dailyReturnChartData = [];
            dailyVolumeChartData = [];
            totalVolumeChartData = [];
            dailyProfitsChartData = [];
            dailyLossesChartData = [];

            //response from request
            arr = JSON.parse(data);
            netReturn = arr[1];
            chartErrMsgs = arr[2];
            tradeCount = arr[4];
            dayReturn = arr[5];
            weekReturn = arr[6];
            monthReturn = arr[7];
            wins = arr[8];
            losses = arr[9];
            wlRatio = wins / losses;
            totalProfits = arr[12];
            totalLosses = arr[13];
            totalVolume = arr[15];
            longVolume = arr[16];
            shortVolume = arr[17];
            avgTradeReturn = arr[23];
            shareVolume = arr[24];
            eps = arr[25];

            prepareTotalReturnChart(arr[0]);
            prepareDailyChartData(arr[3]);
            prepareDailyVolumeChart(arr[14]);
            prepareTotalVolumeChart(arr[20]);
            prepareDailyProfitsChartData(arr[18]);
            prepareDailyLossesChartData(arr[19]);
            prepareTotalProfitsChart(arr[21]);
            prepareTotalLossesChart(arr[22]);

            if (method == 'render') {
                drawReturnChart();
                drawDailyReturnChart();
                drawDailyVolumeChart();
                drawDailyProfitsLossesChart();
                drawTotalVolumeChart();
                drawTotalProfitsLossesChart();
            } else {
                updateReturnCharts();
            }

            if (netReturn >= 0) {
                $('.totalRtrn').text(' $' + netReturn).addClass('greenCol');
            } else {
                $('.totalRtrn').text(' $' + netReturn).addClass('redCol');
            }

            if (dayReturn >= 0) { 
                $('.dayRtrn').text(' $' + dayReturn).addClass('greenCol');
            } else {
                $('.dayRtrn').text(' $' + dayReturn).addClass('redCol');
            }

            if (weekReturn >= 0) {
                $('.weekRtrn').text(' $' + weekReturn).addClass('greenCol');
            } else {
                $('.weekRtrn').text(' $' + weekReturn).addClass('redCol');
            }

            if (monthReturn >= 0) {
                $('.monthRtrn').text(' $' + monthReturn).addClass('greenCol');
            } else {
                $('.monthRtrn').text(' $' + monthReturn).addClass('redCol');
            }

            $('.winsCount span').text(wins);
            $('.lossesCount span').text(losses);
            $('.totalGains span').text('$' + totalProfits);
            $('.totalLosses span').text('$' + totalLosses);
            $('.totalVolume span').text('$' + totalVolume);
            $('.longVolume span').text('$' + longVolume);
            $('.shortVolume span').text('$' + shortVolume);
            if (avgTradeReturn >= 0) {
                $('.avgTradeRtrn span').text(' $' + avgTradeReturn).addClass('greenCol');
            } else {
                $('.avgTradeRtrn span').text(' $' + avgTradeReturn).addClass('redCol');
            }
            $('.shareVolume span').text(shareVolume);
            //$('.epsMetric span').text('$ '+eps);


            if (wins !== 0 && losses !== 0) {
                if (wins >= losses) {
                    $('.wlRatio span').text(wlRatio.toFixed(2)).addClass('greenCol');
                } else {
                    $('.wlRatio span').text(wlRatio.toFixed(2)).addClass('redCol');
                }
            } else {
                $('.wlRatio span').text('NaN');
            }

            $('.tradeCount span').text(tradeCount);

            if (chartErrMsgs.length > 0) {
                errs = chartErrMsgs.length;
                $('.chartErrsData').html('');

                for (i = 0; i < errs; i++) {
                    $('.chartErrsData').append(chartErrMsgs[i]);
                }
                $('.chartErrIcon').show();
            } else {
                $('.chartErrIcon').hide();
            }

            /*
            returnChartData = arr[0];
            totalReturn = arr[1].toFixed();
            outstanding = arr[2].toFixed();
            outstandingCount = arr[3].toFixed();
            buyChartData = arr[4];
            sellChartData = arr[5];
            
            $('.tradeCount span').html(totalReturn);
            $('.winsCount span').html(outstanding);
            prepareReturnChart();
            prepareSellChart(sellChartData);
            prepareBuyChart(buyChartData);
            prepareHwChart(30);
            */
        }
    });
}

function fetchOpenPositions(method) {
    $.ajax({
        type: 'POST',
        url: 'Includes/fetchOpenPositions.inc.php',
        success: function (data) {
            chart_data = JSON.parse(data);

            prepareOpenTradesChartData(chart_data);

            if (method == 'render') {
                drawOpenTradesChart();
            } else {
                updateOpenTradesChart();
            }
        }
    });
}

function loadTopTrades() {
    $.ajax({
        type: 'POST',
        url: 'Includes/load-top-trades.inc.php',
        success: function (data) {
            $('.topTradesInnerInner').html(data);
        }
    });
}