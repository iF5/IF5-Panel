@extends('layouts.panel')

@section('title', 'Gest&atilde;o de usu&aacute;rio')

@section('content')
    <!-- page content -->
    <div class="right_col" role="main">

        <div class="row">
            <div class="x_panel">
                <div class="x_title">
                    <!-- menu breadcrumb -->
                    @include('includes.breadcrumb')
                </div>
                <div class="col-md-12">

                    <div id="dzSuccess"></div>

                    <form method="post" action="{{ route('profile.upload') }}" class="dropzone" id="dzUpload"
                          enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="dz-message">
                            Clique aqui para selecionar o(s) arquivo(s)
                        </div>

                        <div class="dropzone-previews"></div>

                        <button type="submit" id="submit-all" class="btn btn-success" style="cursor: pointer;">Enviar
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- /page content -->
    <script src="{{ asset('js/dropzone.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        Dropzone.options.dzUpload = {

            autoProcessQueue: false,
            uploadMultiple: true,
            maxFilesize: 256,
            maxFiles: 2,

            init: function () {

                var submitButton = document.querySelector('#submit-all');
                var dzUpload = this;

                submitButton.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    dzUpload.processQueue();
                });

                this.on('addedfile', function (file) {
                    var removeButton = Dropzone.createElement('<button class="btn btn-danger btn-xs modal-delete" style="cursor: pointer;"><span class="glyphicon glyphicon-trash"></span></button>');
                    var _this = this;

                    removeButton.addEventListener('click', function (e) {
                        e.preventDefault();
                        e.stopPropagation();
                        _this.removeFile(file);
                    });

                    file.previewElement.appendChild(removeButton);
                    document.getElementById('dzSuccess').innerHTML = '';
                });

                this.on('complete', function (file) {
                    dzUpload.removeFile(file);
                });

                this.on("success", function(file, serverResponse) {
                    var resp = JSON.parse(JSON.stringify(serverResponse));
                    document.getElementById('dzSuccess').innerHTML = resp.message;
                });
            }

        };
    </script>
@endsection