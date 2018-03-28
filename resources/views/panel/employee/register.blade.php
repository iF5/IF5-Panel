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
                <div class="alert alert-info" role="alert">
                    <a href="{{  url('csv/Modelo_Lote_Funcionarios.csv') }}" class="btn btn-default btn-md" download>Clique
                        aqui</a>
                    Para baixar o CSV modelo, do cadastro de funcion&aacute;rios em lote.
                </div>
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
                    <th>Nome</th>
                    <th>Delimitador do CSV</th>
                    <th>Nome do arquivo</th>
                    <th>Status</th>
                    <th>Cadastrado em</th>
                    <th></th>
                    </thead>
                    <tbody>
                    @forelse($registers as $register)
                        <tr>
                            <td>{{ $register->name }}</td>
                            <td><strong>{{ $register->delimiter }}</strong></td>
                            <td>{{ $register->originalFileName }}</td>
                            <td>
                                <p class="{{ $statusClass[$register->status] }}">{{ $register->message }}</p>
                            </td>
                            <td>{{ Period::format($register->createdAt, 'd/m/Y H:i')  }}</td>
                            <td>
                                @if(!$register->status)
                                    <a href="{{ route('employee.register.run', $register->id) }}"
                                       class="btn btn-dark btn-xs register-batch-run"><span
                                                class="glyphicon glyphicon-send" title="Processar"></span></a>
                                @endif
                                <a href="#"
                                   class="btn btn-danger btn-xs modal-delete" title="Excluir"
                                   data-toggle="modal"
                                   data-target="#delete"
                                   rel="{{ route('employee.register.destroy', $register->id) }}"><span
                                            class="glyphicon glyphicon-trash"></span></a>
                            </td>
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
