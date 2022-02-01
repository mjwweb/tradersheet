
    var openTradesChartData = [];
    var openTradesChartCategories = [];
    var openTradesChart;
    //var scatterplotChartData = [];
    //var scatterplotChart;

    function prepareOpenTradesChartData(data) {
        openTradesChartCategories = Object.keys(data);
        openTradesChartData = Object.values(data);
    }

    function drawOpenTradesChart(){
        var options = {
            series: [{
                name: 'Invested',
                data: openTradesChartData
            }],
            chart: {
                type: 'bar',
                height: '97%',
                animations: {
                    enabled: false
                },
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: openTradesChartCategories,
                labels: {
                    style: {
                        colors: '#9e9e9e'
                    }
                }
            },
            yaxis: {
                title: {
                    text: '$USD'
                },
                labels: {
                    style: {
                        colors: '#9e9e9e'
                    }
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    type: 'vertical',
                    opacityFrom: .75,
                    opacityTo: 1,
                    stops: [0, 100]
                }
            },
            grid: {
                show: true,
                borderColor: '#2b2b2b'
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return '$ ' + val
                    }
                }
            }
        };

        openTradesChart = new ApexCharts(document.querySelector("#openTradesChart"), options);
        openTradesChart.render();
    }

    function updateReturnCharts() {
        return_chart.updateSeries([{
            data: returnChartData
        }]);

        dailyReturnChart.updateSeries([{
            data: dailyReturnChartData
        }]);

        dailyVolumeChart.updateSeries([{
            data: dailyVolumeChartData
        }]);

        totalVolumeChart.updateSeries([{
            data: totalVolumeChartData
        }]);

        dailyProfitsLossesChart.updateSeries([{
            data: dailyProfitsChartData
        }, {
            data: dailyLossesChartData
        }]);

        /*
        totalProfitsLossesChart.updateSeries([{
            data: totalProfitsChartData
        }, {
            data: totalLossesChartData
        }]);
        */
    }

    function updateOpenTradesChart() {
        openTradesChart.updateSeries([{
            data: openTradesChartData
        }]);

        openTradesChart.updateOptions({
            xaxis: {
                categories: openTradesChartCategories
            }
        });
    }

    $('.returnChartZoom').change(function () {
        span = $(this).find(':selected').attr('span');
        return_chart.zoomX(
            new Date('10 Jan 2021').getTime(),
            new Date('23 Jul 2021').getTime()
        )
    });























    /*

    function prepareGainsChartData(data) {
        dates = [];
        prices = [];

        dates = Object.keys(data);
        prices = Object.values(data);

        len = dates.length;

        for (i=0; i < len; i++) {
            unix = new Date (dates[i]).getTime();
            price = prices[i];

            gainsChartData.push([unix, price]);
        }
    }

    function preparedailyLossesChartData(data) {
        dates = [];
        prices = [];

        dates = Object.keys(data);
        prices = Object.values(data);

        len = dates.length;

        for (i=0; i < len; i++) {
            unix = new Date (dates[i]).getTime();
            price = prices[i];

            dailyLossesChartData.push([unix, price]);
        }
    }

    function drawGainsdailyLossesChart() {
        var options = {
            colors: ["#00ff0d", "#e60000"],
            chart: {
                id: 'testing',
                group: 'testing',
                type: 'line',
                height: '100%',
                foreColor: '#dedede',
                animations: {
                    enabled: false
                }
            },
            series: [{
                data: gainsChartData
            }, {
                data: dailyLossesChartData
            }],
            xaxis: {
                type: 'datetime',
                //categories: dates,
                labels: {
                    style: {
                        colors: '#828282'
                    },
                    show: true,
                    hideOverlappingLabels: true,
                    rotate: 0
                },
                axisBorder: {
                    show: true
                },
                axisTicks: {
                    show: true
                },
                tooltip: {
                    enabled: true
                },
                crosshairs: {
                    show: true
                }
            },
            yaxis: {
                tooltip: {
                    enabled: false
                },
                labels: {
                    show: true,
                    formatter: function (value) {
                        return '$'+value
                    },
                    minWidth: 0
                },
                crosshairs: {
                    show: false,
                    position: 'back',
                    stroke: {
                        color: 'lightgreen',
                        dashArray: 3
                    }
                }
            },
            stroke: {
                curve: 'smooth',
            },
            dataLabels: {
                enabled: false
            },
            grid: {
                show: true,
                borderColor: '#2b2b2b'
            },
            fill: {
                gradient: {
                enabled: true,
                color: '#ff4040',
                opacityFrom: 0.75,
                opacityTo: 0.2
                }
            }
        }

        gainsdailyLossesChart = new ApexCharts(document.querySelector("#dailyReturnChart"), options);
        gainsdailyLossesChart.render();
    }

    */






























    /*

    function prepareSellChart(data) {
        dates = [];
        prices = [];

        dates = Object.keys(data);
        prices = Object.values(data);

        drawSellChart(dates, prices);
    }

    function prepareBuyChart(data) {
        dates = [];
        prices = [];

        dates = Object.keys(data);
        prices = Object.values(data);

        drawBuyChart(dates, prices);
    }

    function drawBuyChart(dates, prices) {
        var options = {
            chart: {
                type: 'area',
                height: '100%',
                foreColor: '#dedede',
                animations: {
                    enabled: true
                },
                toolbar: {
                    show: false
                }
            },
            series: [{
                data: prices
            }],
            xaxis: {
                type: 'datetime',
                categories: dates,
                labels: {
                    style: {
                        colors: '#828282'
                    },
                    show: true
                },
                axisBorder: {
                    show: true
                },
                axisTicks: {
                    show: true
                },
                tooltip: {
                    enabled: true
                },
                crosshairs: {
                    show: true
                }
            },
            yaxis: {
                tooltip: {
                    enabled: true
                },
                labels: {
                    show: true,
                    formatter: function (value) {
                        return '$'+value
                    }
                },
                crosshairs: {
                    show: true,
                    stroke: {
                        color: 'lightgreen',
                        dashArray: 3
                    }
                }
            },
            stroke: {
                curve: 'smooth',
                colors: ['#de1818'],
            },
            dataLabels: {
                enabled: false
            },
            grid: {
                show: true,
                borderColor: '#2b2b2b'
            },
            fill: {
                colors: ['#de1818'],
                gradient: {
                    enabled: true,
                    opacityFrom: 0.55,
                    opacityTo: 0
                }
            }
        }

        var chart = new ApexCharts(document.querySelector("#buy_chart"), options);
        chart.render();
    }

    function drawSellChart(dates, prices) {
        var options = {
            chart: {
                type: 'area',
                height: '100%',
                foreColor: '#dedede',
                animations: {
                    enabled: true
                },
                toolbar: {
                    show: false
                }
            },
            series: [{
                data: prices
            }],
            xaxis: {
                type: 'datetime',
                categories: dates,
                labels: {
                    style: {
                        colors: '#828282'
                    },
                    show: true
                },
                axisBorder: {
                    show: true
                },
                axisTicks: {
                    show: true
                },
                tooltip: {
                    enabled: true
                },
                crosshairs: {
                    show: true
                }
            },
            yaxis: {
                tooltip: {
                    enabled: true
                },
                labels: {
                    show: true,
                    formatter: function (value) {
                        return '$'+value
                    }
                },
                crosshairs: {
                    show: true,
                    stroke: {
                        dashArray: 3
                    }
                }
            },
            stroke: {
                colors: ['#18d94b'],
                curve: 'smooth',
            },
            dataLabels: {
                enabled: false
            },
            grid: {
                show: true,
                borderColor: '#2b2b2b'
            },
            fill: {
                colors: ['#18d94b'],
                gradient: {
                    enabled: true,
                    color: '#ff4040',
                    opacityFrom: 0.55,
                    opacityTo: 0
                }
            }
        }

        var chart = new ApexCharts(document.querySelector("#sell_chart"), options);
        chart.render();
    }
/*
    function prepareHwChart(days) {
        dateArr = lastXDays(days);
        dataLen = Object.keys(returnChartData).length;

        dates = [];
        prices = [];
        
        Object.keys(returnChartData).forEach(function(key){
            date = key;
            price = returnChartData[key];

            if (dateArr.indexOf(date) != -1) {
                dates.push(date);
                prices.push(price);
            }
        });

        drawSparkline(dates, prices);
    }

    function drawSparkline(data) {
        var options = {
            chart: {
                type: 'line',
                height: '100%',
                width: '100%',
                foreColor: '#dedede',
                sparkline: {
                    enabled: true
                },
                animations: {
                    enabled: true
                }
            },
            series: [{
                data: data
            }],
            xaxis: {
                type: 'datetime',
                //categories: dates,
                labels: {
                    style: {
                        colors: '#828282'
                    },
                    show: false
                },
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false
                },
                tooltip: {
                    enabled: false
                },
                crosshairs: {
                    show: true
                },
                min: 1860814800000
            },
            yaxis: {
                tooltip: {
                    enabled: true
                },
                labels: {
                    show: false
                },
                crosshairs: {
                    show: true,
                    stroke: {
                        color: 'lightgreen',
                        dashArray: 3
                    }
                }
            },
            stroke: {
                width: 2,
                curve: 'smooth',
            },
            dataLabels: {
                enabled: false
            },
            grid: {
                borderColor: '#000'
            },
            fill: {
                gradient: {
                enabled: true,
                color: '#ff4040',
                opacityFrom: 0.55,
                opacityTo: 0
                }
            }
        }

        var chart = new ApexCharts(document.querySelector(".hwChart"), options);
        chart.render();
    }

    */