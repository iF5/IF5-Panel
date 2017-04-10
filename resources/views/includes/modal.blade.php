<!-- modal-delete -->

<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span
                            class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                <h4 class="modal-title custom_align" id="Heading">Aten&ccedil;&atilde;o</h4>
            </div>
            <div class="modal-body">

                <div class="alert alert-danger">
                    Tem certeza que deseja excluir este registro?
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

<!-- modal-update -->

<div class="modal fade" id="update" tabindex="-1" role="dialog" aria-labelledby="update" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span
                            class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                <h4 class="modal-title custom_align" id="Heading">Aten&ccedil;&atilde;o</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning alert-message-update">
                </div>
            </div>
            <div class="modal-footer ">
                <form id="form-modal-update" method="post" action="" style="float: right;">
                    {{ method_field('PUT') }}
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

<!-- /modal-update -->

<!-- modal-upload -->

<div class="modal fade" id="upload" tabindex="-1" role="dialog" aria-labelledby="upload" aria-hidden="true"
     data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <a href="" class="close"><span class="glyphicon glyphicon-remove"></span></a>
                <h4 class="modal-title custom_align" id="Heading">Upload</h4>
            </div>
            <div class="modal-body">

                <div id="dz-modal-message"></div>

                <form id="dz-modal-upload" method="post" action="" class="dropzone" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="dz-message">
                        Clique aqui para selecionar ou arraste e solte o(s) arquivo(s)
                    </div>

                    <div class="dropzone-previews"></div>

                    <button type="submit" id="dz-modal-submit" class="btn btn-success" style="cursor: pointer;">Enviar
                    </button>
                </form>

            </div>
            <div class="modal-footer ">
                <a href="" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> Fechar</a>
            </div>
        </div>
    </div>
</div>

<!-- /modal-upload -->