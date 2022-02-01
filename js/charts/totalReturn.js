var returnChartData = [];
var return_chart;

function prepareTotalReturnChart(data) {
    dates = Object.keys(data);
    prices = Object.values(data);

    len = dates.length;
    plen = prices.length;

    firstD = dates[0];
    firstP = prices[0];


    for (i = 0; i < len; i++) {
        unix = new Date(dates[i]).getTime();
        price = prices[i];

        returnChartData.push([unix, price]);
    }
}

function drawReturnChart() {

    var options = {
        chart: {
            id: 'testing',
            group: 'testing',
            type: 'area',
            height: '100%',
            foreColor: '#dedede',
            animations: {
                enabled: false
            }
        },
        series: [{
            name: 'Total Return',
            data: returnChartData
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
                enabled: false
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
                    return '$' + value
                },
                minWidth: 50
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

    return_chart = new ApexCharts(document.querySelector("#pl_chart"), options);
    return_chart.render();
    setTimeout(function () {
        //$('.returnChartsWrap').fadeIn(1000);
        $('.keyMetricSection').fadeIn(200);
    }, 100);
}