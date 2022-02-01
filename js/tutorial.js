$(document).ready(function () {

    df = localStorage.getItem('demo-form');
    dashboardMsg = localStorage.getItem('dashboardMsg');
    spreadsheetMsg = localStorage.getItem('spreadsheetMsg');
    tf1 = localStorage.getItem('tf1');
    tf2 = localStorage.getItem('tf2');

    if (df !== '1') {
        $('.demo-form-backdrop').fadeIn('fast');
    } else if (dashboardMsg !== '1') {
        $('.dashboard-overlay').fadeIn('fast');
    } else if (spreadsheetMsg !== '1') {
        $('.spreadsheet-overlay').fadeIn('fast');
    } else if (tf1 !== '1') {
        $('.tf-1').fadeIn('fast');
    } else if (tf2 !== '1') {
        $('.tf-2').fadeIn('fast');
    }

});

$('.df-btn').click(function () {
    localStorage.setItem('demo-form', '1');
    $('.demo-form-backdrop').hide();
    if (dashboardMsg !== '1') {
        $('.dashboard-overlay').fadeIn('fast');
    }
});

$('.dashboard-modal button').click(function(){
    localStorage.setItem('dashboardMsg', '1');
    $('.dashboard-overlay').hide();
    if (spreadsheetMsg !== '1') {
        $('.spreadsheet-overlay').fadeIn('fast');
    }
});

$('.spreadsheet-modal button').click(function(){
    localStorage.setItem('spreadsheetMsg', '1');
    $('.spreadsheet-overlay').hide();
    if (tf1 !== '1') {
        $('.tf-1').fadeIn('fast');
    }
});

$('.tf-1 button').click(function () {
    localStorage.setItem('tf1', '1');
    $('.tf-1').hide();
    if (tf2 !== '1') {
        $('.tf-2').fadeIn('fast');
    }
});

$('.tf-2 button').click(function () {
    localStorage.setItem('tf2', '1');
    $('.tf-2').hide();
});