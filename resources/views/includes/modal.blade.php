<!-- modal-delete -->

<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span
                            class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                <h4 class="modal-title custom_align" id="Heading">Aten&ccedil;&atilde;o</h4>
            </div>
            <div class="modal-body">

                <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> Tem certeza
                    de
                    que deseja excluir este registro?
                </div>

            </div>
            <div class="modal-footer ">
                <form id="form-modal-delete" method="post" action="" style="float: right;">
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}
                    <button class="btn btn-success" type="submit"><span class="glyphicon glyphicon-ok-sign"></span> Sim
                    </button>
                </form>

                <button type="button" class="btn btn-default" data-dismiss="modal"><span
                            class="glyphicon glyphicon-remove"></span> N&atilde;o
                </button>
            </div>
        </div>
    </div>
</div>

<!-- /modal-delete -->