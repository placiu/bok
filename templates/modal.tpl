<script>$(function () { $('#modal').modal() });</script>

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                {{message}}
            </div>
            <div class="modal-footer">
                {{button}}
                <button type="button" class="btn btn-danger" data-dismiss="modal">Zamknij</button>
            </div>
        </div>
    </div>
</div>