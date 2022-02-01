var loadingTradeLogRows = false;

$(document).ready(function () {
    loadTradeLog(true);
});

function fetchApiKey() {
    $.ajax({
        type: 'POST',
        url: 'Includes/fetchApiKey.inc.php',
        success: function (r) {
            $('.apiKey').text(r);
            $('.apiKeyWindow').show();
        }
    });
}

function fetchActiveAccountName() {
    $.ajax({
        type: 'POST',
        url: 'Includes/fetchActiveAccountName.inc.php',
        success: function (r) {
            if ($.trim(r) !== '') {
                $('.activeAccount').text(r);
            } else {
                $('.newAccountForm').show();
                $('.activeAccount').text('Create new account');
            }
        }
    });
}

//load trade log with trades with erros

function loadErrTrades(id) {
    $.ajax({
        type: 'POST',
        url: 'Includes/loadErrTrades.inc.php',
        data: {
            id: id
        },
        success: function (data) {
            $('.tradeLogData').append(data);
            $('.exitDateCol input, .entryDateCol input').flatpickr({});
        }
    });
}

function logoutUser() {
    $.ajax({
        type: 'POST',
        url: 'Includes/logoutUser.inc.php',
        success: function () {
            window.location.reload();
        }
    });
}

$(document).ready(function () {
    $('.randLogBtn').click(function () {
        $.ajax({
            type: 'POST',
            url: 'Includes/loadRandomLog.inc.php',
            success: function (r) {
                alert(r);
            }
        });
    });
});



















/*

    function loadOpenTrades() {
        $.ajax({
            type: 'POST',
            url: 'Includes/loadTargetsLog.inc.php',
            data: {type: type, openLogStart: openLogStart, openLogLimit: openLogLimit, closedLogStart: closedLogStart, closedLogLimit: closedLogLimit},
            success: function(data) {
                $('.tradeLogData').html(data);

                if (type == 'open') {
                    openLogStart += openLogLimit;
                }
                else {
                    closedLogStart += closedLogLimit;
                }
            }
        });
    }

    function loadClosedTrades() {
        $.ajax({
            type: 'POST',
            url: 'Includes/loadTargetsLog.inc.php',
            data: {type: type, openLogStart: openLogStart, openLogLimit: openLogLimit, closedLogStart: closedLogStart, closedLogLimit: closedLogLimit},
            success: function(data) {
                $('.tradeLogData').html(data);

                if (type == 'open') {
                    openLogStart += openLogLimit;
                }
                else {
                    closedLogStart += closedLogLimit;
                }
            }
        });
    }

    */