<div class="row mt-5" id="content" style="min-height: 500px">
    <div class="col-3 colHeight">
        <div class="page-header">
            <h3>Wszystkie wątki</h3>
        </div>
        <div>
            <table class="table" id="allConversationsTable">
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
    <div class="col-3 colHeight">
        <div class="page-header">
            <h3>Moje wątki</h3>
        </div>
        <div>
            <table class="table" id="myConversationsTable">
                <thead>
                    <tr>
                        <th>Temat</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    {{openConverstaions}}
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-6 colHeight">
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
    <div class="col-3"></div>
    <div class="col-3"></div>
</div>