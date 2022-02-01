    
    defaultAddTradeDate(); // set the add trade form entry date to today

    function defaultAddTradeDate() {
        today = new Date();
        defaultDate = formatDate(today);

        $('.atfEntryDate').flatpickr({
            defaultDate: defaultDate
        });
        $('.atfExitDate').flatpickr();
    }

    $('#addTradeBtn').click(function () {
        $('.addTradeForm').show();
        $('.addTradeForm').animate({
            opacity: 1,
            top: "+=15"
        }, 130);

        if ($('.tf-1').is(':visible')) {
            $('.tf-1 button').trigger('click');
        }
    });

    $('.atfSide').click(function(){
        side = $(this).attr('side');
        $('.atfSide').removeClass('atfActSide');
        $(this).addClass('atfActSide');
    });

    $('.atfClosedChbx').change(function () {
        if ($(this).is(':checked')) {
            $('.tradeFormClosedRow').css('display', 'flex');
        } else {
            $('.tradeFormClosedRow').hide();
        }
    });

    $('.saveNewTrade').click(function () {
        side = $('.atfActSide').attr('side');
        symbol = $('.atfSymbol').val().trim();
        entryDate = $('.atfEntryDate').val().trim();
        entryPrice = $('.atfEntryPrice').val().trim();
        qty = $('.atfQty').val().trim();
        fees = $('.atfFees').val().trim();
        exitDate = null;
        exitPrice = null;

        formErrs = false;

        if ($('.atfClosedChbx').is(':checked')) {
            exitDate = $('.atfExitDate').val();
            exitPrice = $('.atfExitPrice').val();
        }

        $('.atfInput').each(function () {
            if ($(this).val().trim() == '' && $(this).is(':visible') && !$(this).hasClass('atfFees')) {
                formErrs = true;
                $(this).addClass('emptyInputErr');
                elem = $(this).attr('class');
            }
        });

        if (formErrs == false) {
            saveNewTrade(side, symbol, entryDate, entryPrice, qty, fees, exitDate, exitPrice);
        }
    });

    function saveNewTrade(side, symbol, entryDate, entryPrice, qty, fees, exitDate, exitPrice) {
        $.ajax({
            type: 'POST',
            url: 'Includes/saveNewTrade.inc.php',
            data: {
                side: side,
                symbol: symbol,
                entryDate: entryDate,
                entryPrice: entryPrice,
                qty: qty,
                fees: fees,
                exitDate: exitDate,
                exitPrice: exitPrice
            },
            success: function (r) {
                tradeLogStart = 0;
                tradeLogLimit = 50;
                //closeTradeForm(true);
                resetTradeForm();
                loadTradeLog(false);
                updateDashboard();
            }
        });
    }

    $('.atfInput').change(function(){
        if ($(this).val().trim() !== '') {
            $(this).removeClass('emptyInputErr');
        }
    });

    $('.atfQty, .atfEntryPrice').keyup(function () {
        this.value = this.value.replace(/[^0-9\.]/g,'');
    });

    $('.cancelNewTrade').click(function () {
        closeTradeForm(true);
    });

    function closeTradeForm(reset) {
        $('.addTradeForm').hide().css({
            opacity: '0',
            top: '40px'
        });
        $('.atfInput').removeClass('emptyInputErr');

        if (reset) {
            $('.atfInput, .atfInputInac').val('');
            $('.atfSide').removeClass('atfActSide');
            $('.atfSide[side="Long"]').addClass('atfActSide');
            defaultAddTradeDate();
        }
    }

    function resetTradeForm() {
        $('.atfInput, .atfInputInac').not('.atfEntryDate, .atfExitDate').val('');
    }


    /*

    $('.atfEntryPrice').change(function(){
        atfOrderAmount();
    });

    $('.atfQty').change(function(){
        atfOrderAmount();
    });

    function atfOrderAmount() {
        entryPrice = $('.atfEntryPrice').val().trim();
        qty = $('.atfQty').val().trim();
        
        if (entryPrice && qty) {
            amount = entryPrice * qty;
            $('.atfOrderAmt').val('$'+amount.toFixed(2));
        } else {
            $('.atfOrderAmt').val('');
        }
    }

    */