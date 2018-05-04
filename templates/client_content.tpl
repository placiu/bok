<div class="row mt-5" id="content" style="min-height: 500px">
    <div class="col-4 colHeight">
        <div class="page-header">
            <h3>Wątki</h3>
        </div>
        <div>
            <table class="table" id="conversationsTable">
                <thead>
                    <tr>
                        <th>Temat</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    {{conversations}}
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-8 colHeight">
        <div class="page-header">
            <h3>Chat</h3>
        </div>
        <div>
            <table class="table table-striped" id="messagesTable">
                <thead>
                    <tr>
                        <th>Nadawca</th>
                        <th>Wiadomość</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
<div class="row mt-10" id="forms">
    <div class="col-md-4">
        <form id="conversationForm" class="form-inline" method="post" action="">
            <input id="conversationSubject" class="form-control" name="conversationSubject" type="text" placeholder="Temat..." required><button class="btn btn-warning" type="submit">Dodaj</button>
        </form>
    </div>
</div>