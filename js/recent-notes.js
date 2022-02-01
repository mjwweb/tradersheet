//loadRecentNotes();

function loadRecentNotes() {
    $.ajax({
        type: 'POST',
        url: 'Includes/load-recent-notes.inc.php',
        success: function(r) {
            data = $.trim(r);
            $('.topTradesInner').html(data);
        }
    });
}