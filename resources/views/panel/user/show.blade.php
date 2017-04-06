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

            <ul class="list-group">
                <li class="list-group-item">
                    <img src="{{ asset('images/profile/'. $user->image) }}" width="100" alt="...">
                </li>
                <li class="list-group-item"><strong>Nome : </strong> {{ $user->name }}</li>
                <li class="list-group-item"><strong>E-mail : </strong> {{ $user->email }}</li>
                <li class="list-group-item"><strong>Cpf : </strong> {{ $user->cpf }}</li>
                <li class="list-group-item"><strong>Cargo : </strong> {{ $user->jobRole }}</li>
                <li class="list-group-item"><strong>Setor : </strong> {{ $user->department }}</li>
                <li class="list-group-item"><strong>Telefone : </strong> {{ $user->phoneNumber }}</li>
                <li class="list-group-item"><strong>Celular : </strong> {{ $user->cellPhoneNumber }}</li>

                <li class="list-group-item">
                    @if($routePrefix === 'profile')

                        <a href="{{ route('profile.edit') }}"
                           class="btn btn-success btn-md" title="Editar"><span
                                    class="glyphicon glyphicon-pencil"></span>
                        </a>
                        <a href=""
                           class="btn btn-primary btn-md modal-image" title="Imagem" data-toggle="modal"
                           data-target="#upload" rel="{{ route('profile.upload') }}">
                            <span class="glyphicon glyphicon-picture"></span>
                        </a>

                    @else

                        <a href="{{ route( $routePrefix . '.edit', $user->id) }}"
                           class="btn btn-success btn-md" title="Editar"><span
                                    class="glyphicon glyphicon-pencil"></span>
                        </a>
                        <a href="#"
                           class="btn btn-danger btn-md modal-delete"
                           data-toggle="modal" data-target="#delete" title="Excluir"
                           rel="{{ route($routePrefix . '.destroy', $user->id) }}"><span
                                    class="glyphicon glyphicon-trash"></span>
                        </a>

                    @endif
                </li>
            </ul>
        </div>
    </div>
</div>
<script src="{{ asset('js/dropzone.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    Dropzone.options.dzModalUpload = {

        autoProcessQueue: false,
        uploadMultiple: false,
        maxFilesize: 500,
        maxFiles: 1,

        init: function () {

            var submitButton = document.querySelector('#submitModalUpload');
            var dzModalUpload = this;

            submitButton.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                dzModalUpload.processQueue();
            });

            this.on('addedfile', function (file) {
                var removeButton = Dropzone.createElement(config.buttonXsRemove);
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
                dzModalUpload.removeFile(file);
            });

            this.on("success", function (file, serverResponse) {
                var resp = JSON.parse(JSON.stringify(serverResponse));
                document.getElementById('dzSuccess').innerHTML = resp.message;
            });
        }

    };
</script>

<!-- /page content -->
@endsection
