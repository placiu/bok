$(function () {
    let allConversationsTable = $('#allConversationsTable');
    let allConversationsTableBody = allConversationsTable.find('tbody');
    let myConversationTable = $('#myConversationsTable');
    let myConversationsTableBody = myConversationTable.find('tbody');
    let messagesTableBody = $('#messagesTable').find('tbody');
    let forms = $('#forms');
    let firstConversationId = myConversationsTableBody.find('td').eq(0).data('id');

    if (firstConversationId) {
        removeHighlights();
        highlightFirstRow();
        getMessages(firstConversationId);
        createMessageForm(firstConversationId);
    }

    myConversationsTableBody.on('click', 'tr', function () {
        let tr = $(this);
        let conversationId = tr.find('td').data('id');
        removeHighlights();
        removeTransfer();
        addHighlight(tr);
        addTransfer(tr);
        emptyMessages();
        getMessages(conversationId);
        createMessageForm(conversationId);
    });

    allConversationsTableBody.on('click', '#transfer', function (event) {
        event.stopPropagation();
        let tr = $(this).parent().parent();
        let conversationId = tr.find('td').data('id');
        moveConversation(conversationId, tr);
    });

    myConversationsTableBody.on('click', '#transfer', function(event) {
        event.stopPropagation();
        let tr = $(this).parent().parent();
        let conversationId = tr.find('td').data('id');
        moveConversation(conversationId, tr);
    });

    forms.on('submit', '#newMessageForm', function (event) {
        event.preventDefault();
        addMessage($(this).serialize());
    });

    // ----------------------------------------------------------------

    function moveConversation(id, tr) {
        $.ajax({
            url: '../api/router.php/Conversation/' + id,
            type: 'PATCH',
            dataType: 'json'
        }).done(function (result) {
            let array = result.success;
            if (array === 'moveToMyConversation') {
                removeHighlights();
                removeTransfer();
                tr.clone().appendTo(myConversationsTableBody);
                tr.remove();
                let countTr = myConversationTable.find('tr').length;
                let lastTr = myConversationTable.find('tr').eq(countTr-1);
                addHighlight(lastTr);
                getMessages(id);
                createMessageForm(id);
            } else if (array === 'moveToAllConversation') {
                tr.clone().appendTo(allConversationsTableBody);
                tr.remove();
                removeHighlights();
                emptyMessages();
            }
        });
    }

    function getMessages(conversationId) {
        emptyMessages();
        $.get('../api/router.php/Message/' + conversationId)
            .done(function (result) {
                let array = result.success;
                if (array && array.length > 0) {
                    array.forEach(function (element) {
                        let senderLogin = element.senderLogin;
                        let message = element.message;
                        let dateTime = element.datetime;
                        createMessage(senderLogin, message, dateTime);
                    });
                }
            });
    }

    function createMessage(login, message, date) {
        let tr = $('<tr>');
        let td1 = $('<td>');
        let td2 = $('<td>');
        td1.text(login);
        td2.html(message + '<br><small>' + date + '</small>');
        td1.appendTo(tr);
        td2.appendTo(tr);
        tr.hide();
        tr.appendTo(messagesTableBody).fadeIn(1000);
    }

    function createMessageForm(id) {
        forms.find('#formMessageDiv').remove();
        let div = $('<div class="col-6" id="formMessageDiv">');
        let form = $('<form id="newMessageForm" class="form-inline" method="post">');
        let inputMessage = $('<input id="message" class="form-control " name="message" type="text" placeholder="Wiadomość...">');
        let inputId = $('<input id="id" name="id" value="' + id + '" type="hidden">');
        let button = $('<button class="btn btn-success" type="submit">');
        button.text('Wyślij');
        inputId.appendTo(form);
        inputMessage.appendTo(form);
        button.appendTo(form);
        form.appendTo(div);
        div.hide();
        div.appendTo(forms).fadeIn('slow');
    }

    function addMessage(data) {
        $.post('../api/router.php/Message/', data)
            .done(function (result) {
                let array = result.success;
                if (array && array.length > 0) {
                    let senderLogin = array[0].senderLogin;
                    let message = array[0].message;
                    let dateTime = array[0].datetime;
                    createMessage(senderLogin, message, dateTime);
                }
            });
    }

    function highlightFirstRow() {
        myConversationTable.find('tr').removeClass('bg-warning');
        removeTransfer();
        let tr = myConversationTable.find('tr').eq(1).addClass('bg-warning');
        addTransfer(tr);
    }

    function addHighlight(tr) {
        tr.addClass('bg-warning');
    }

    function removeHighlights() {
        myConversationTable.find('tr').removeClass('bg-warning');
        allConversationsTable.find('tr').removeClass('bg-warning');
    }

    function emptyMessages() {
        messagesTableBody.empty();
        forms.find('#formMessageDiv').remove();
    }

    function addTransfer(tr) {
        tr.find('td.transfer').html('<button class="btn btn-default mt-1" id="transfer"><span class="fa fa-exchange"></span></button>');
    }

    function removeTransfer() {
        myConversationTable.find('tr').find('td.transfer').html('');
    }

});