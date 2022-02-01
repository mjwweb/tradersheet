
    var hwTimespan = 30;
    var focusFired = false;

    var local = false;

    if (location.hostname === "localhost" || location.hostname === "127.0.0.1") {
        local = true;
    }

    $('.apiDocsBtn').click(function(){
        if (local == true) {
            window.location.href = 'http://localhost/tradersheet/api';
        } else {
            window.location.href = 'https://tradersheet.io/api';
        }
    });

    $('#settingsBtn').click(function(){
        $(this).addClass('settingsBtnAct');
        $('.settingsForm').show();
        $('.settingsForm').animate({
            opacity: 1,
            top: "+=15"
        }, 130);
    });

    $('.supportSettingsRow').click(function(){
        window.location.href = window.location.href + 'support';
    });

    $('.apiSettingsRow').click(function(){
        window.location.href = window.location.href + 'api';
    });

    $('.settingsBillingRow').click(function(){
        if (local == false) {
            $.ajax({
                type: 'POST',
                url: 'stripe/customer-portal-session.php',
                success: function(r) {
                    if ($.trim(r) == 'login required') {
                        alert('Please login to tradersheet.io with your credentials');
                    } else {
                        window.location.href = r;
                    }
                }
            });
        }
    });

    $('.metricsBtn').click(function(){
        $(this).addClass('metricsBtnFocus');
        $('.metricsWrap').toggle();
    });

    $(window).on('resize', function(){
        win = $(this).width();
        if (win > 1000 && $('.metricsWrap').is(':hidden')) {
            $('.metricsWrap').show();
        }
    });

    $('.signoutBtn').click(function(){
        logoutUser();
    });

    $('.hwBtn').click(function(){
        hwtimespan = $(this).attr('value');
        prepareHwChart();
    });

    /*

    $('.openTradesChbx, .closedTradesChbx').change(function(){
        openTrades = false;
        closedTrades = false;

        if ($('.openTradesChbx').is(':checked')) {
            openTrades = true;
        }
        if ($('.closedTradesChbx').is(':checked')) {
            closedTrades = true;
        }

        loadTradeLog(false);
    });

    */

    // focus row on field click
    $(document).on('focus', '.mInput', function(){
        $('.spreadsheetRow').removeClass('rowFocus');

        id = $(this).parents('.spreadsheetRow').attr('id');
        $('.spreadsheetRow[id="'+id+'"]').addClass('rowFocus');
    });

    // clear row focus on outside click
    $(document).on('blur', '.mInput', function(){
        $('.spreadsheetRow').removeClass('rowFocus');
    });

    //chart error messages 
    $(document).on('click', '.chartErrIcon', function(){
        $(this).addClass('chartErrIconFocus');
        topPos = $(this).offset().top + 35;
        errCount = $('.chartErrsData p').length;
        $('.chartErrsTop span').text('Trade Warnings: '+errCount);
        $('.chartErrs').css('top', topPos).show();
    });

    $(window).on('resize', function(){
        if ($('.chartErrs').is(':visible')) {
            topPos = $('.chartErrIcon').offset().top + 35;
            $('.chartErrs').css('top', topPos);
        }
        if ($('.sideSelect').is(':visible')) {
            $('.sideSelect').hide();
        }
    });

    $('.showTradeErrs').click(function(){
        $('.tradeLogHdrDflt, .tradeLogHdrErrs').toggle();
        $('.tradeLogData').html('');
        $('.chartErrsData p').each(function(){
            id = $(this).attr('tid');
            
            loadErrTrades(id);
        });
    });

    $('.errLogBack').click(function(){
        $('.tradeLogHdrDflt, .tradeLogHdrErrs').toggle();
        $('.tradeChbx').prop('checked', false);
        $('.deleteTradesBtn').hide();

        loadTradeLog(false);
    });

    //form close outside click
    
    $(document).on('mousedown', function(e){
        if (!$('.sideSelect').is(e.target) && $('.sideSelect').has(e.target).length === 0) {
            $('.sideSelect').hide();
        }
        if (!$('.confNoteDelete').is(e.target) && $('.confNoteDelete').has(e.target).length === 0) {
            $('.confNoteDelete').hide().css('opacity', '0');
        }
        if (!$('.srchSymWrap').is(e.target) && $('.srchSymWrap').has(e.target).length === 0) {
            hideSearchBarResults();
        }
        if (!$('.chartErrs').is(e.target) && $('.chartErrs').has(e.target).length === 0) {
            $('.chartErrs').hide();
            $('.chartErrIcon').removeClass('chartErrIconFocus');
        }
        if (!$('.sortColMenu').is(e.target) && $('.sortColMenu').has(e.target).length === 0) {
            $('.sortColMenu').hide();
            $('.orderIconsWrap').removeClass('orderIconFocus');
        }
        if (!$('.addTradeForm').is(e.target) && $('.addTradeForm').has(e.target).length === 0) {
            if (!$('.flatpickr-calendar').is(e.target) && $('.flatpickr-calendar').has(e.target).length === 0) {
                closeTradeForm(false);
            }
        }
        if (!$('.metricsWrap').is(e.target) && $('.metricsWrap').has(e.target).length === 0 && $(window).width() < 1000) {
            $('.metricsWrap').hide();
            $('.metricsBtn').removeClass('metricsBtnFocus');
        }
        if (!$('.settingsForm').is(e.target) && $('.settingsForm').has(e.target).length === 0) {
            $('#settingsBtn').removeClass('settingsBtnAct');
            $('.settingsForm').hide();
            $('.settingsForm').css({top: '35px', opacity: '0'});
        }
        if (!$('.apiKeyWindow').is(e.target) && $('.apiKeyWindow').has(e.target).length === 0) {
            $('.apiKeyWindow').hide();
        }
        if (!$('#accountDropdownWrap').is(e.target) && $('#accountDropdownWrap').has(e.target).length === 0) {
            if ($('.accountDropdownResultsWrap').is(':visible')) {
                hideAccountDropdown();
            }
        }
        if (!$('.tradeInfoWindow').is(e.target) && $('.tradeInfoWindow').has(e.target).length === 0) {
            $('.tradeInfoBackdrop').hide();
        }
    });