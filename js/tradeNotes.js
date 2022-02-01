

    // event listeners

    // spreadsheet icon click

    $(document).on('click', '.showTradeNotes', function(){
        id = $(this).parents('.tradeLogDataRow').attr('id');
        symbol =  $(this).parents('.tradeLogDataRow').attr('symbol');

        if ($('.tradeNotesWrap[tradeId="'+id+'"]').length == 0) {
            loadTradeNotes(id, symbol);
        }
    });

    // trade note window x

    $(document).on('click', '.closeTradeNotes', function(){
        $(this).parents('.tradeNotesHolder').remove();
    });

    // input change

    $(document).on('change', '.tradeNoteInpt', function(){
        if (tradeNoteFunc == false) {
            tradeNoteChange($(this));
        }
    });

    // enter key press on input

    $(document).on('keydown', '.tradeNoteInpt', function(e){
        if (e.keyCode == '13') {
            e.stopPropagation();
            e.preventDefault();

            if ($(this).val().trim() !== '' && tradeNoteFunc == false) {
                tradeNoteChange($(this));
            }
        }
    });

    // main delete button click

    $(document).on('click', '.deleteNoteBtn', function(){
        noteId = $(this).parents('.tradeNoteWrap').attr('noteId');
        $('.tradeNoteWrap[noteId="'+noteId+'"]').children('.tradeNoteInpt').focus();

        left = $(this).offset().left - 60;
        topPos = $(this).offset().top - 4;
        windowIndex++;

        $('.confNoteDelete').css({'top': topPos, 'left': left, 'z-index': windowIndex}).show();
        $('.deleteTradeNote').attr('noteId', noteId);


        $('.confNoteDelete').animate({
            left: '-=20px',
            opacity: '1'
        }, 100);

    });

    // delete note confirm button

    $(document).on('click', '.deleteTradeNote', function(){
        $(this).parents('.confNoteDelete').hide();
        noteId = $(this).attr('noteId');
        deleteTradeNote(noteId);
    });

    // bring window to front on mousedown

    $(document).on('mousedown', '.tradeNotesHolder', function(){
        windowIndex++;

        $(this).css('z-index', windowIndex);
    });

    //ajax -- save trade note

    function saveTradeNote(tradeId, noteId, note, symbol) {
        $.ajax({
            type: 'POST',
            url: 'Includes/saveTradeNote.inc.php',
            data: {tradeId: tradeId, noteId: noteId, note: note, symbol: symbol},
            success: function(newId) {
                tradeNoteFunc = false;
                
                if ($.trim(newId) !== '') {
                    noteElem = $('.tradeNoteInpt').parents('.tradeNoteWrap[noteId="'+noteId+'"]');
                    noteElem.attr('noteId', newId);
                }

                // update the recent notes window
                //loadRecentNotes();
            }
        });
    }

    //load all notes

    var windowIndex = 9999;

    function loadTradeNotes(id, symbol) {
        $.ajax({
            type: 'POST',
            url: 'Includes/loadTradeNotes.inc.php',
            data: {id: id, symbol: symbol},
            success: function(data) {
                windowId = Math.floor(Math.random() * 26) + Date.now();
                $('body').append('<div wid="'+windowId+'" class="tradeNotesHolder '+windowId+'"></div>');
                $('.'+windowId).html(data).show();

                //$('.'+windowId).resizable();
                $('.'+windowId).draggable({
                    handle: '.tradeNotesTopBar',
                    create: function(event, ui) {
                        windowIndex++;
                        $(this).css('z-index', windowIndex);
                    },
                    containment: 'body',
                    delay: 100
                });

                $('.'+windowId).resizable();
                //$('.tradeNotesWrap').sortable();
                //$('.tradeNotesWrap').overlayScrollbars({});

                $('.'+windowId).addClass('animateTradeNotes');
                $('.'+windowId).find('.tradeNoteInpt').focus();
                $('.tradeNoteInpt').autogrow({vertical: true, horizontal: false, flickering: true});
            }
        });
    }

    // delete trade note func

    function deleteTradeNote(noteId) {
        $('.tradeNoteWrap[noteId="'+noteId+'"]').remove();

        $.ajax({
            type: 'POST',
            url: 'Includes/deleteTradeNote.inc.php',
            data: {noteId: noteId},
            success: function() {
                // update the recent notes window
                //loadRecentNotes();
            }
        });

    }

    var tradeNoteFunc = false;

    function tradeNoteChange(elem) {
        tradeNoteFunc = true;

        tradeId = elem.parents('.tradeNotesWrap').attr('tradeId');
        symbol = elem.parents('.tradeNotesWrap').attr('symbol');
        noteId = elem.parents('.tradeNoteWrap').attr('noteId');
        note = elem.val().trim();
        windowId = elem.parents('.tradeNotesHolder').attr('wid');
        
        if (elem.parents('.tradeNoteWrap').hasClass('newTradeNoteWrap')) {
            elem.parents('.tradeNoteWrap').removeClass('newTradeNoteWrap');

            uniqid = Math.floor(Math.random() * 26) + Date.now();
            elem.parents('.tradeNotesWrap').append('<div class="tradeNoteWrap newTradeNoteWrap" noteId="'+uniqid+'"><span class="tnBullet">•</span><textarea rows="1" class="tradeNoteInpt" placeholder="Type new note" /></textarea><span class="deleteNoteBtn"><i class="bi bi-trash"></i></span></div>');
            $('.tradeNoteInpt').blur();
            $('.newTradeNoteWrap[noteId="'+uniqid+'"]').find('.tradeNoteInpt').focus();
            $('.tradeNoteInpt').autogrow({vertical: true, horizontal: false, flickering: false});
        }

        saveTradeNote(tradeId, noteId, note, symbol);
    }