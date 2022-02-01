

    function setRowNumbers() {
        num = 0;
        $('.tradeLogDataRow > .rowNumCol span').each(function(){
            num++;
            $(this).text(num);
        });
    }

    function datePreview(selectedDates) {
        options = { weekday: 'short', month: 'long', day: 'numeric' };
        obj = new Date(selectedDates);
        preview = obj.toLocaleDateString('en-US', options);
        return preview;
    }

    function formatDate(date) {
        var dd = date.getDate();
        var mm = date.getMonth()+1;
        var yyyy = date.getFullYear();
        if (dd<10) {dd='0'+dd}
        if (mm<10) {mm='0'+mm}
        date = yyyy+'-'+mm+'-'+dd;
        return date
    }

    function lastXDays(x) {
        var result = [];
        for (var i=0; i<x; i++) {
            var d = new Date();
            d.setDate(d.getDate() - i);
            result.push( formatDate(d) )
        }

        return(result);
    }
















    /*

        function setOrderIcon() {
        $('.orderIcon').remove();

        if (tradeLogOrder.indexOf(' asc') > -1) {
            column = tradeLogOrder.replace(' asc', '');
            $('.spreadsheetTradeLabels div[column="'+column+'"]').append('<img class="orderIcon" current="asc" src="Icons/orderUp.png" />');
        }
        else {
            column = tradeLogOrder.replace(' desc', '');
            $('.spreadsheetTradeLabels div[column="'+column+'"]').append('<img class="orderIcon" current="desc" src="Icons/orderDown.png" />');
        }
    }

        function setOrderIcon() {
        $('.orderIcon').remove();

        if (activeLog == 'spreadsheet') {
            tradeLogOrder = localStorage.getItem('tradeLogOrder');

            if (tradeLogOrder.indexOf(' asc') > -1) {
                column = tradeLogOrder.replace(' asc', '');
                $('.spreadsheetTradeLabels div[column="'+column+'"]').append('<img class="orderIcon" current="asc" src="Icons/orderUp.png" />');
            }
            else {
                column = tradeLogOrder.replace(' desc', '');
                $('.spreadsheetTradeLabels div[column="'+column+'"]').append('<img class="orderIcon" current="desc" src="Icons/orderDown.png" />');
            }
        }

        if (activeLog == 'open') {
            openLogOrder = localStorage.getItem('openLogOrder');

            if (openLogOrder.indexOf(' asc') > -1) {
                column = openLogOrder.replace(' asc', '');
                $('.openTradesLabels div[column="'+column+'"]').append('<img class="orderIcon" current="asc" src="Icons/orderUp.png" />');
            }
            else {
                column = openLogOrder.replace(' desc', '');
                $('.openTradesLabels div[column="'+column+'"]').append('<img class="orderIcon" current="desc" src="Icons/orderDown.png" />');
            }
        }

        if (activeLog == 'closed') {
            closeLogOrder = localStorage.getItem('closeLogOrder');

            if (closeLogOrder.indexOf(' asc') > -1) {
                column = closeLogOrder.replace(' asc', '');
                $('.closedTradesLabels div[column="'+column+'"]').append('<img class="orderIcon" current="asc" src="Icons/orderUp.png" />');
            }
            else {
                column = closeLogOrder.replace(' desc', '');
                $('.closedTradesLabels div[column="'+column+'"]').append('<img class="orderIcon" current="desc" src="Icons/orderDown.png" />');
            }
        }
    }

    function updateOutstanding() {
        outstandingCount = 0;
        outstanding = 0;
        $('.exitPriceCol input').each(function(){
            val = $(this).val();

            if ($.trim(val) == '') {
                row = $(this).attr('row');
                outstandingCount++;
                bought = Number($('.entryPriceCol input[row="'+row+'"]').val());
                outstanding -= bought;
            }
        });
        if (outstandingCount !== 1) {
            $('.winsCount span').text('$'+outstanding+' ('+outstandingCount+' moments)');
        } else {
            $('.winsCount span').text('$'+outstanding+' ('+outstandingCount+' moment)');
        }
    }

    function updateTotalPL() {
        num = 0;
        $('.netReturnCol input').each(function(){
            val = $(this).val();
            if (val !== 'TBD') {
                num += Number(val);
            }
        });
        revenue = Math.round(num * 100) / 100;
        $('.tradeCount span').text(' +$'+revenue);
    }


    function preparePlBarChart(data) {
        dates = [];
        prices = [];

        dates = Object.keys(data);
        prices = Object.values(data);

        drawPlBarChart(dates, prices);
    }

    function drawPlBarChart(dates, prices) {
        var options = {
            series: [{
            name: 'Cash Flow',
            data: prices
          }],
            chart: {
            type: 'bar',
            height: 150,
            toolbar: {
                show: false
            }
          },
          dataLabels: {
            enabled: false,
          },
          yaxis: {
              labels: {
                  show: false
              }
          },
          xaxis: {
            type: 'datetime',
            categories: dates
          },
          grid: {
            borderColor: '#000'
          },
          plotOptions: {
            bar: {
              colors: {
                ranges: [{
                  from: 1,
                  to: 10000000,
                  color: '#1bc900'
                }, {
                  from: 0,
                  to: -10000000,
                  color: '#FEB019'
                }]
              }
            }
            }
          };
  
          var chart = new ApexCharts(document.querySelector("#pl_bar_chart"), options);
          chart.render();
    }

    */