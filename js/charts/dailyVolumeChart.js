    
    
    var dailyVolumeChart;
    var dailyVolumeChartData = [];

    function prepareDailyVolumeChart(data) {
        dates = Object.keys(data);
        prices = Object.values(data);

        len = dates.length;

        for (i = 0; i < len; i++) {
            unix = new Date(dates[i]).getTime();
            price = prices[i];

            dailyVolumeChartData.push([unix, price]);
        }
    }

    function drawDailyVolumeChart() {
        var options = {
            colors: ["#FFA500", "#FFA500"],
            chart: {
                id: 'testing',
                group: 'testing',
                type: 'line',
                height: '100%',
                foreColor: '#dedede',
                animations: {
                    enabled: false
                },
                toolbar: {
                    show: false
                },
                zoom: {
                    autoScaleXaxis: true
                }
            },
            series: [{
                name: 'Daily Volume',
                data: dailyVolumeChartData
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
                curve: 'straight',
                width: 2
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

        dailyVolumeChart = new ApexCharts(document.querySelector("#dailyVolumeChart"), options);
        dailyVolumeChart.render();
    }