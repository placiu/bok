$(function () {

    let conversationsTable = $('#conversationsTable');
    let conversationsTableBody = $('#conversationsTable').find('tbody');
    let conversationForm = $('#conversationForm');
    let messagesTableBody = $('#messagesTable').find('tbody');
    let forms = $('#forms');
    let firstConversationId = $('#conversationsTable').find('tbody').find('td').eq(0).data('id');

    if (firstConversationId) {
        highlightFirstRow();
        getMessages(firstConversationId);
        createMessageForm(firstConversationId);
    }

    conversationsTableBody.on('click', 'tr', function () {
        let tr = $(this);
        let conversationId = tr.find('td').data('id');
        addHighlight(tr);
        emptyMessages();
        getMessages(conversationId);
        createMessageForm(conversationId);
    });

    conversationsTableBody.on('click', '#delete', function(event) {
        event.stopPropagation();
        let tr = $(this).parent().parent();
        let conversationId = tr.find('td').data('id');
        deleteConversation(conversationId, tr);
    });

    conversationForm.submit(function (event) {
        event.preventDefault();
        addConversation($(this).serialize());
    });

    forms.on('submit', '#newMessageForm', function (event) {
        event.preventDefault();
        addMessage($(this).serialize());
    });

    // ----------------------------------------------------------------

    function addConversation(data) {
        $.post('../api/router.php/Conversation/', data)
            .done(function (result) {
                let array = result.success;
                if (array && array.length > 0) {
                    let conversationId = array[0].id;
                    let conversation = array[0].conversation;
                    let conversationDate = array[0].date;
                    createConversation(conversationId, conversation, conversationDate);
                    highlightFirstRow();
                    emptyMessages();
                    createMessageForm(conversationId);
                }
            });
    }

    function deleteConversation(conversationId, tr) {
        $.ajax({
            url: '../api/router.php/Conversation/' + conversationId,
            type: 'DELETE',
            dataType: 'json'
        }).done(function() {
            tr.remove();
            emptyMessages();
        });
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

    function createConversation(conversationId, topic, date) {
        let tr = $('<tr>');
        let td1 = $('<td data-id="' + conversationId + '">');
        let td2 = $('<td class="text-right trash">');
        td1.html(topic + '<br><small>' + date + '</small>');
        tr.append(td1);
        tr.append(td2);
        tr.hide();
        tr.prependTo(conversationsTableBody).fadeIn('slow');
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
        let div = $('<div class="col-8" id="formMessageDiv">');
        let form = $('<form id="newMessageForm" class="form-inline" method="post">');
        let inputMessage = $('<input id="message" class="form-control " name="message" type="text" placeholder="Wiadomość..." required>');
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

    function highlightFirstRow() {
        conversationsTable.find('tr').removeClass('table-warning');
        removeTrash();
        let tr = conversationsTable.find('tr').eq(1).addClass('table-warning');
        addTrash(tr);
    }

    function addHighlight(tr) {
        conversationsTable.find('tr').removeClass('table-warning');
        removeTrash();
        tr.addClass('table-warning');
        addTrash(tr);
    }

    function emptyMessages() {
        messagesTableBody.empty();
        forms.find('#formMessageDiv').remove();
    }

    function addTrash(tr) {
        tr.find('td.trash').html('<button class="btn btn-default mt-1" id="delete"><span class="fa fa-trash"></span></button>');
    }

    function removeTrash() {
        conversationsTable.find('tr').find('td.trash').html('');
    }

});