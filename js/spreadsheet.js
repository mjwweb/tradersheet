    var tradeLogStart = 0;
    var tradeLogLimit = 45;

    //load trade log data
    function loadTradeLog(appendData) {
        loadingTradeLogRows = true;

        //symbol filter
        symbol = $('.srchSymInpt').val().trim().toUpperCase();

        $.ajax({
            type: 'POST',
            url: 'Includes/loadTradeLog.inc.php',
            data: {
                symbol: symbol,
                start: tradeLogStart,
                limit: tradeLogLimit
            },
            success: function (data) {

                if (appendData == true) {
                    $('.tradeLogSheetInner').append(data);
                } else {
                    $('.tradeLogSheetInner').html(data);
                }

                $('.exitDateCol input, .entryDateCol input').flatpickr({});

                //loadMomentPL();
                //setOrderIcon();
                setRowNumbers();
                tradeLogStart += tradeLogLimit;
                loadingTradeLogRows = false;

                $('.loaderIcon').remove();
                $('.sortColMenu').hide();
                $('.orderIconsWrap').removeClass('orderIconFocus');

            }

        });
    }

    //delete trade
    function deleteTrades(id) {
        $.ajax({
            type: 'POST',
            url: 'Includes/deleteTrade.inc.php',
            data: {
                id: id
            },
            success: function () {
                $('.spreadsheetRow[id="' + id + '"]').remove();
                $('.deleteTradesWindow').hide();
                $('.deleteTradesBtn').hide();
                updateDashboard();
            }
        });
    }

    //load more rows on trade log scroll
    function tradeLogScroll() {
        scrollElem = $('.tradeLogSheet').find('.os-viewport');

        if (scrollElem.scrollTop() + scrollElem.innerHeight() >= (scrollElem[0].scrollHeight) - 5) {
            if (loadingTradeLogRows == false) {
                loadTradeLog(true);
            }
        }
    }



    //spreadsheet fullscreen
    $('.ssFullscreenBtn').click(function () {
        if (!$('.bottomWindowWrap').hasClass('ssFullscreen')) {
            $('.bottomWindowWrap').addClass('ssFullscreen');
            $('.ssFullscreenBtn').html('<i class="bi bi-fullscreen-exit"></i>');
        } else {
            $('.bottomWindowWrap').removeClass('ssFullscreen');
            $('.ssFullscreenBtn').html('<i class="bi bi-arrows-fullscreen"></i>');
        }
    });

    //delete trades top bar click
    $(document).on('click', '.deleteTradesBtn', function () {
        $('.deleteTradesWindow').fadeIn('fast');
    });

    //delete trades modal confirm click
    $(document).on('click', '.deleteTradesConfirm', function () {
        $('.tradeChbx:checked').each(function () {
            id = $(this).parents('.spreadsheetRow').attr('id');

            deleteTrades(id);
        });

        setTimeout(function () {
            updateDashboard();
        }, 1000);
    });

    //cancel delete trades modal click
    $('.cancelDeleteTrades').click(function () {
        $('.deleteTradesWindow').hide();
        $('.tradeChbx').prop('checked', false);
        $('.deleteTradesBtn').hide();
    });

    //show column sorting menu
    $(document).on('click', '.orderIconsWrap', function () {
        $(this).addClass('orderIconFocus');
        column = $(this).parents('.tlLabelCol').attr('column');
        $('.sortColMenu').attr('column', column);

        topPos = $(this).offset().top + $(this).height() + 7;
        leftPos = $(this).offset().left + $(this).width() - 200;

        if (leftPos < 0) {
            leftPos = $(this).offset().left;
        }

        $('.sortColMenu').css({
            top: topPos,
            left: leftPos
        }).slideToggle(120);
    });

    //column sort click -> show loader icon
    $('.sortColMenuRow').click(function () {
        column = $(this).parents('.sortColMenu').attr('column');
        direction = $(this).attr('direction');

        $(this).append('<img class="loaderIcon" src="gif/spinner1.gif" />');

        $.ajax({
            type: 'POST',
            url: 'Includes/setLogOrder.inc.php',
            data: {
                column: column,
                direction: direction
            },
            success: function () {
                tradeLogStart = 0;
                tradeLogLimit = 50;

                loadTradeLog(false);
            }
        });

    });

    ////////column change event listeners////////
    ////////////////////////////////////////////

    //symbol
    $(document).on('change', '.symbolCol input', function () {
        id = $(this).parents('.tradeLogDataRow').attr('id');
        symbol = $(this).val();
        updateSymbol(id, symbol);
    });

    $(document).on('change', '.categoryCol input', function () {
        id = $(this).parents('.tradeLogDataRow').attr('id');
        category = $(this).val();
        updateCategory(id, category);
    });

    //side
    $(document).on('click', '.sideCol input', function () {
        left = $(this).offset().left;
        bottom = $(this).offset().top + $(this).height();
        id = $(this).parents('.tradeLogDataRow').attr('id');
        width = $(this).parents('.sideCol').width();

        $('.sideSelect').css({
            'top': bottom,
            'left': left,
            'width': width
        }).attr('rowId', id).show();
    });

    //side select
    $(document).on('click', '.sideSelectItem', function () {
        id = $(this).parents('.sideSelect').attr('rowId');
        side = $(this).attr('side');

        $('.tradeLogDataRow[id="' + id + '"] > .sideCol input').val(side);
        $(this).parents('.sideSelect').hide();

        calculateTradePrices(id);
    });

    //entry date
    $(document).on('change', '.entryDateCol input', function () {
        id = $(this).parents('.tradeLogDataRow').attr('id');
        date = $(this).val();
        updateEntryDate(id, date);
    });

    //exit date
    $(document).on('change', '.exitDateCol input', function () {
        id = $(this).parents('.tradeLogDataRow').attr('id');
        date = $(this).val();
        updateExitDate(id, date);
    });

    //quantity
    $(document).on('change', '.qtyCol input', function () {
        id = $(this).parents('.tradeLogDataRow').attr('id');
        calculateTradePrices(id);
    });

    //entry price
    $(document).on('change', '.entryPriceCol input', function () {
        id = $(this).parents('.tradeLogDataRow').attr('id');
        calculateTradePrices(id);
    });

    //exit price
    $(document).on('change', '.exitPriceCol input', function () {
        id = $(this).parents('.tradeLogDataRow').attr('id');
        calculateTradePrices(id);
    });

    //fees
    $(document).on('change', '.feeCol input', function () {
        id = $(this).parents('.tradeLogDataRow').attr('id');
        calculateTradePrices(id);
    });

    //stop loss
    $(document).on('change', '.stopLossCol input', function () {
        id = $(this).parents('.spreadsheetRow').attr('id');
        stopLoss = $(this).val();
        updateStopLoss(id, stopLoss);
    });

    //take profit
    $(document).on('change', '.takeProfitCol input', function () {
        id = $(this).parents('.spreadsheetRow').attr('id');
        takeProfit = $(this).val();
        updateTakeProfit(id, takeProfit);
    });

    //trade delete checkbox change
    $(document).on('change', '.tradeChbx', function () {
        checkedTradesCount = 0;
        checkedTrades = false;

        $('.tradeChbx').each(function () {
            if ($(this).is(':checked')) {
                checkedTradesCount++;
                checkedTrades = true;
            }
        });

        if (checkedTrades == false) {
            $('.deleteTradesBtn').hide();
        } else {
            if (checkedTradesCount == 1) {
                buttonText = 'Delete ' + checkedTradesCount + ' trade';
            } else {
                buttonText = 'Delete ' + checkedTradesCount + ' trades';
            }
            $('.deleteTradesBtn').text(buttonText).show();
            $('.deleteTradesForm h4').text(buttonText);
        }
    });

    //////////save column changes/////////////
    ///////////////////////////////////////////

    //update symbol
    function updateSymbol(id, symbol) {
        $.ajax({
            type: 'POST',
            url: 'Includes/updateSymbol.inc.php',
            data: {
                id: id,
                symbol: symbol
            },
            success: function () {

            }
        });
    }

    //update category
    function updateCategory(id, category) {
        $.ajax({
            type: 'POST',
            url: 'Includes/updateCategory.inc.php',
            data: {
                id: id,
                category: category
            },
            success: function (r) {
            }
        });
    }

    //update entry date
    function updateEntryDate(id, date) {
        $.ajax({
            type: 'POST',
            url: 'Includes/updateEntryDate.inc.php',
            data: {
                id: id,
                date: date
            },
            success: function () {

            }
        });
    }

    //update exit date
    function updateExitDate(id, date) {
        $.ajax({
            type: 'POST',
            url: 'Includes/updateExitDate.inc.php',
            data: {
                id: id,
                date: date
            },
            success: function (newId) {
                //savedNotif(id);
                //loadTargetsLog(targetsLog);
                updateDashboard();

                if (newId) {
                    rowElem = $('.tradeLogDataRow[id="' + id + '"]');
                    rowElem.attr('id', newId);
                }
            }
        });
    }

    //update price columns
    function updatePrices(id, status, side, qty, entry, exit, entryAmt, exitAmt, fees, netReturn, roi) {

        $.ajax({
            type: 'POST',
            url: 'Includes/updatePrices.inc.php',
            data: {
                id: id,
                side: side,
                status: status,
                qty: qty,
                entry: entry,
                exit: exit,
                entryAmt: entryAmt,
                exitAmt: exitAmt,
                fees: fees,
                netReturn: netReturn,
                roi: roi
            },
            success: function (newId) {
                //savedNotif();
                //loadTargetsLog(targetsLog);
                updateDashboard();

                if (newId) {
                    rowElem = $('.tradeLogDataRow[id="' + id + '"]');
                    rowElem.attr('id', newId);
                }
            }
        });
    }

    //update stop loss
    function updateStopLoss(id, stopLoss) {
        $.ajax({
            type: 'POST',
            url: 'Includes/updateStopLoss.inc.php',
            data: {
                id: id,
                stopLoss: stopLoss
            },
            success: function () {

            }
        });
    }

    //update take profit
    function updateTakeProfit(id, takeProfit) {
        $.ajax({
            type: 'POST',
            url: 'Includes/updateTakeProfit.inc.php',
            data: {
                id: id,
                takeProfit: takeProfit
            },
            success: function () {

            }
        });
    }

    //update trade log sort
    function saveMomentSort(column, action) {
        $.ajax({
            type: 'POST',
            url: 'Includes/setMomentOrder.inc.php',
            data: {
                column: column,
                action: action
            },
            success: function (data) {
                $('.tradeLogData').html(data);
                $('.exitDateCol input, .entryDateCol input').flatpickr();
                loadMomentPL();
            }
        });
    }

    //Udate revenue row on input change
    function calculateTradePrices(id) {
        side = $('.tradeLogDataRow[id="' + id + '"] > .sideCol input').val();
        qty = $('.tradeLogDataRow[id="' + id + '"] > .qtyCol input').val().trim();
        entry = $('.tradeLogDataRow[id="' + id + '"] > .entryPriceCol input').val().trim();
        exit = $('.tradeLogDataRow[id="' + id + '"] > .exitPriceCol input').val().trim();
        fees = $('.tradeLogDataRow[id="' + id + '"] > .feeCol input').val().trim();
        entryAmt = null;
        exitAmt = null;
        roi = null;

        if (qty !== '' && entry !== '') {
            entryAmt = entry * qty;
        }
        if (qty !== '' && exit !== '') {
            exitAmt = exit * qty;
        }

        if (entry == '' || exit == '' || qty == '') {
            netReturn = null;
        } else {
            if (side == 'Long') {
                netReturn = (exitAmt - entryAmt) - fees;
                netReturn = netReturn.toFixed(2);
            }
            if (side == 'Short') {
                netReturn = (entryAmt - exitAmt) - fees;
                netReturn = netReturn.toFixed(2);
            }
            roi = (netReturn / entryAmt) * 100;
            roi = roi.toFixed(2);
        }

        if (entry !== '' && exit !== '') {
            status = 'Closed';
            statusClass = 'redCol';
        } else {
            status = 'Open';
            statusClass = 'greenCol';
        }

        if (roi >= 0) {
            roiClass = 'greenCol';
        } else {
            roiClass = 'redCol';
        }

        if (netReturn >= 0) {
            returnClass = 'greenCol';
        } else {
            returnClass = 'redCol';
        }

        $('.tradeLogDataRow[id="' + id + '"] > .statusCol input').val(status).removeClass('redCol greenCol').addClass(statusClass);
        $('.tradeLogDataRow[id="' + id + '"] > .entryAmtCol input').val(entryAmt);
        $('.tradeLogDataRow[id="' + id + '"] > .exitAmtCol input').val(exitAmt);

        if ($.trim(roi) !== '') {
            $('.tradeLogDataRow[id="' + id + '"] > .netRoiCol input').val(roi + '%').removeClass('redCol greenCol').addClass(roiClass);
        } else {
            $('.tradeLogDataRow[id="' + id + '"] > .netRoiCol input').val('').removeClass('redCol greenCol');
        }

        $('.tradeLogDataRow[id="' + id + '"] > .netReturnCol input').val(netReturn).removeClass('redCol greenCol').addClass(returnClass);

        updatePrices(id, status, side, qty, entry, exit, entryAmt, exitAmt, fees, netReturn, roi);
    }