$('.accountSelect').niceSelect();

$('.accountSelect').change(function () {
    accountId = $(this).find(':selected').attr('accountId');

    $.ajax({
        type: 'POST',
        url: '../Includes/fetchApiKey.inc.php',
        data: {
            id: accountId
        },
        success: function (data) {
            $('.accountApiKey').text(data);
        }
    });
});

//javascript / jquery code sample toggle

$('.reqCodeType').click(function () {
    $('.reqCodeType').removeClass('actExBtn');
    $(this).addClass('actExBtn');

    if ($(this).hasClass('jqEx')) {
        $('.apiJsSampleRequest').hide();
        $('.apiJqSampleRequest').show();
    } else {
        $('.apiJqSampleRequest').hide();
        $('.apiJsSampleRequest').show();
    }
});

// parameter section toggle

$('.parameterHdrWrap').click(function () {
    section = $(this).attr('for');
    $('.' + section).slideToggle('fast');
    $(this).find('.sectionChevron').toggleClass('fa-chevron-down fa-chevron-up');
    $(this).toggleClass('parameterHdrOpen');
});

// overlay scrollbars

$(document).ready(function () {
    $('.columnSortValues').overlayScrollbars({});
    $('body').overlayScrollbars({});
});

$('.bkgTint').click(function(){
    $('.apiWindow').fadeOut('fast');
    $(this).hide();
});