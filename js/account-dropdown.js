

    $('.accountDropdownInner').click(function(){
        fetchAccounts();
    });

    $(document).on('click', '.accountDropdownResultRow', function(e){
        if (!$(e.target).hasClass('editAccountBtn')) {
            account_id = $(this).attr('accountId');
            switchAccounts(account_id);
            hideAccountDropdown();
        }
    });

    $(document).on('click', '.editAccountBtn', function(){
        account_name = $(this).attr('accountName');
        account_id = $(this).attr('accountId');

        showEditAccountForm(account_name, account_id);
        hideAccountDropdown();
    });

    $('.eaf-deleteAccountBtn').click(function(){
        account_id = $('.editAccountForm').attr('accountId');
        account_name = $('.editAccountForm').attr('accountName');
        $('.editAccountWindow, .confirmAccountDeleteWindow').toggle();
        $('.cadf-name span').text(account_name);
        $('.cadf-confirmBtn').attr('accountId', account_id);
    });

    $('.addAccountBtn').click(function(){
        $('.newAccountWindow').show();
        $('.naf-name').focus();

        hideAccountDropdown();
    });

    $('.naf-x, .naf-cancelBtn').click(function(){
        hideNewAccountForm();
    });

    $('.eaf-x, .eaf-cancelBtn').click(function(){
        hideEditAccountForm();
    });

    $('.cadf-x, .cadf-cancelBtn').click(function(){
        hideConfirmAccountDeleteForm();
    });

    $('.naf-saveBtn').click(function(){
        accountName = $('.naf-name').val().trim();
        if (accountName == '') {
            $('.naf-name').addClass('naf-name-empty');
        } 
        else {
            createNewAccount(accountName);
        }
    });

    $('.eaf-saveBtn').click(function(){
        account_name = $('.eaf-name').val().trim();
        account_id = $('.editAccountForm').attr('accountId');
        if (account_name == '') {
            $('.eaf-name').addClass('eaf-name-empty');
        } 
        else {
            editAccountName(account_name, account_id);
        }
    });

    $('.cadf-confirmBtn').click(function(){
        account_name_verify = $('.cadf-confirmInput').val().trim();
        account_id = $(this).attr('accountId');

        deleteAccount(account_name_verify, account_id);
    });

    $('.naf-name').keydown(function(){
        if ($(this).hasClass('naf-name-empty')) {
            $(this).removeClass('naf-name-empty');
        }
    });

    $('.eaf-name').keydown(function(){
        if ($(this).hasClass('eaf-name-empty')) {
            $(this).removeClass('eaf-name-empty');
        }
    });

    $('.cadf-confirmInput').keydown(function(){
        if ($(this).hasClass('cadf-confirmInput-err')) {
            $(this).removeClass('cadf-confirmInput-err');
        }
    });

    function hideAccountDropdown() {
        $('.accountDropdownResultsWrap').hide();
        $('#accountDropdownWrap').removeClass('accountDropdownActive');
        $('.accountDropdownArrow').toggleClass('bi-caret-down-fill, bi-caret-up-fill');
    }

    function hideNewAccountForm() {
        $('.formBackdrop').hide();
        $('.naf-name').val('').removeClass('naf-name-empty');
    }

    function hideEditAccountForm() {
        $('.formBackdrop').hide();
        $('.eaf-name').val('').removeClass('eaf-name-empty');
    }

    function hideConfirmAccountDeleteForm() {
        $('.formBackdrop').hide();
        $('.cadf-confirmInput').val('');
    }

    function showEditAccountForm(account_name, account_id) {
        $('.editAccountWindow').show();
        $('.editAccountForm').attr('accountId', account_id).attr('accountName', account_name);
        $('.eaf-name').val(account_name).focus();
    }

    // ajax

    function fetchAccounts() {
        $.ajax({
            type: 'POST',
            url: 'Includes/fetchAccounts.inc.php',
            success: function(r) {
                data = $.trim(r);
                $('.userAccounts').html(data);
                $('.accountDropdownResultsWrap').toggle();
                $('#accountDropdownWrap').toggleClass('accountDropdownActive');
                $('.accountDropdownArrow').toggleClass('bi-caret-down-fill, bi-caret-up-fill');
            }
        });
    }

    function createNewAccount(accountName) {
        $('.newAccountForm').hide();

        $.ajax({
            type: 'POST',
            url: 'Includes/createNewAccount.inc.php',
            data: {accountName: accountName},
            success: function() {
                window.location.reload();
            }
        });
    }

    function editAccountName(account_name, account_id) {
        $('.editAccountForm').hide();

        $.ajax({
            type: 'POST',
            url: 'Includes/editAccountName.inc.php',
            data: {account_name: account_name, account_id: account_id},
            success: function(r) {
                fetchActiveAccountName();
                hideEditAccountForm();
            }
        });

    }

    function switchAccounts(account_id) {
        $.ajax({
            type: 'POST',
            url: 'Includes/switchAccounts.inc.php',
            data: {account_id: account_id},
            success: function() {
                window.location.reload();
            }
        });
    }

    function deleteAccount(account_name_verify, account_id) {
        $.ajax({
            type: 'POST',
            url: 'Includes/deleteAccount.inc.php',
            data: {account_name_verify: account_name_verify, account_id: account_id},
            success: function(r) {
                if ($.trim(r) == 'bad name match') {
                    $('.cadf-confirmInput').addClass('cadf-confirmInput-err');
                }
                else {
                    window.location.reload();
                }
            }
        });
    }

    // close forms on outside click

    $('.newAccountWindow').click(function(e){
        if ($('.formBackdrop').is(e.target)) {
            hideNewAccountForm();
        }
    });

    $('.editAccountWindow').click(function(e){
        if ($('.formBackdrop').is(e.target)) {
            hideEditAccountForm();
        }
    });

    $('.confirmAccountDeleteWindow').click(function(e){
        if ($('.formBackdrop').is(e.target)) {
            hideConfirmAccountDeleteForm();
        }
    });