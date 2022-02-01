

    $(document).ready(function() {

        // scollbar overlays

        $('.tradeLogSheet').overlayScrollbars({
            scrollbars: {
                //autoHide: 'scroll'
            },
            callbacks: {
                onScroll: function(eventArgs) {
                    tradeLogScroll();
                }
            }
        });

        $('.bottomWindowWrap').overlayScrollbars({});
        $('.srchSymBottom').overlayScrollbars({});
        $('.apiWindow').overlayScrollbars({});
        $('.apiSortValues').overlayScrollbars({});
        //$('.dashboardLeft').overlayScrollbars({});
        $('.topTradesInner').overlayScrollbars({});
        $('.tradeInfoInner').overlayScrollbars({});
        $('.returnChartsWrap').overlayScrollbars({});
        $('.keyMetricSection').overlayScrollbars({});

        fetchActiveAccountName(); // set the account name in the account select menu

        /*
        apiKey = '$2y$10$dzX1hZWLf9vCTO/SxSUDV.dfM0XqZBvYJyUZMCOyUrQao0H/u2/x6';

        let xhr = new XMLHttpRequest();
        xhr.open('GET', 'api/?key='+apiKey+'&order=nrtdesc&limit=2');
        xhr.send();
        xhr.onload = function() {
            data = JSON.parse(xhr.response);
            console.log(data);
        };

        $.ajax({
            type: 'POST',
            url: 'api/?key='+apiKey+'&order=nrtdesc&limit=2',
            success: function(data) {
                //alert(data);
                json_data = JSON.parse(data);

                console.log(json_data);
            }
        });
        */

    });
    