
var tradeInfoSymbol;

$(document).on('click', '.tradeInfoCol i', function(){
    tradeInfoSymbol = $(this).attr('symbol');

    loadTradeInfoContent();
});

$(document).on('click', '.avSaveNewKeyBtn', function(){
    key = $('.avSaveNewKeyInpt').val().trim();

    if (key == '') {
        $('.avSaveNewKeyInpt').addClass('avSaveNewKeyInptErr');
    }
    else {
        $.ajax({
            type: 'POST',
            url: 'Includes/save-alphavantage-key.inc.php',
            data: {key: key},
            success: function(r) {
                alert(r);
            }
        });
    }
});

$(document).on('keypress', '.avSaveNewKeyInpt', function(){
    if ($(this).hasClass('avSaveNewKeyInptErr')) {
        $(this).removeClass('avSaveNewKeyInptErr');
    }
});

$(document).on('focus', '.avSaveNewKeyInpt', function(){
    $('.avSaveNewKeyInpt').removeClass('avSaveNewKeyInptErr');
});

function loadTradeInfoContent() {
    $.ajax({
        type: 'POST',
        url: 'Includes/alphavantage-key.inc.php',
        data: {symbol: tradeInfoSymbol},
        success: function(data) {
            $('.tradeInfoWindow').html(data);
            $('.tradeInfoBackdrop').show();
        }
    });
}