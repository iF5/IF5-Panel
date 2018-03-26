@extends('layouts.panel')

@section('title', 'Gest&atilde;o de funcion&aacute;rios')

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
                    <form method="post">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <input type="text" id="name" name="name" class="form-control"
                                       placeholder="D&ecirc; um nome para o lote" value="">
                            </div>
                            <div class="form-group col-md-3">
                                <select id="delimiter" name="delimiter" class="form-control">
                                    <option value="">Informe o delimitador do csv</option>
                                    <option value=";">; Ponto e v&iacute;rgula</option>
                                    <option value=",">, V&iacute;rgula</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <a href="{{ route('employee.register.upload') }}" id="modal-register-employee-upload"
                                   class="btn btn-success">
                                    Cadastrar lote
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-md-12" style="margin-top: 20px;">
                    <table id="provider-table" class="table table-bordred table-striped">
                        <thead>
                        <th></th>
                        <th>Nome</th>
                        <th>Delimitador do CSV</th>
                        <th>Nome do arquivo</th>
                        <th>Status</th>
                        <th>Cadastrado em</th>
                        </thead>
                        <tbody>
                        @forelse($registers as $register)
                            <tr>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
                                            <span class='glyphicon glyphicon-cog'></span> <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li>
                                                <a href="">Rodar</a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                                <td>{{ $register->name }}</td>
                                <td><strong>{{ $register->delimiter }}</strong></td>
                                <td>{{ $register->originalFileName }}</td>
                                <td>{{ $register->message }}</td>
                                <td>{{ Period::format($register->createdAt, 'd/m/Y H:i')  }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" align="center">Nenhum registro foi encontrado.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- /page content -->
@endsection
