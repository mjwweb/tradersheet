    

    // event listeners

    $('.srchSymInner').click(function(){
        if (!$(this).hasClass('srchSymFocus')) {

            $(this).addClass('srchSymFocus');
            $('.srchSymInpt').focus();
            
            loadSpreadsheetFilterSymbols('null');
            
        }
    });

    $(document).on('click', '.srchSymRslts p', function(){
        symbol = $(this).text();
        $('.srchSymInpt').val(symbol);

        tradeLogStart = 0;
        tradeLogLimit = 50;

        hideSearchBarResults();
        loadTradeLog(false);
    });

    $('.srchSymInpt').change(function(){
        if ($(this).val().trim() == '') {
            loadTradeLog(false);
        }
    });

    $('.srchSymInpt').keyup(function(){
        query = $(this).val().trim();
        loadSpreadsheetFilterSymbols(query);
    });

    // other functions 

    function hideSearchBarResults() {
        $('.srchSymInpt').blur();
        $('.srchSymInner').removeClass('srchSymFocus');
        $('.srchSymBottom').hide();
    }

    // ajax functions 

    function loadSpreadsheetFilterSymbols(query) {
        $.ajax({
            type: 'POST',
            url: 'Includes/loadTradeSymbols.inc.php',
            data: {query: query},
            success: function(data) {
                $('.srchSymRslts').html(data);
                $('.srchSymBottom').show();
            }
        });
    }