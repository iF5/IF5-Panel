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

                <form>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="name">D&ecirc; um nome para o lote</label>
                            <input type="text" class="form-control" id="name">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="delimiter">Informe o delimitador do csv</label>
                            <select id="delimiter" class="form-control">
                                <option value=";">; Ponto e v&iacute;rgula</option>
                                <option value=",">, V&iacute;rgula</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <br />
                            <button type="submit" class="btn btn-success">Cadastrar lote</button>
                        </div>

                    </div>

                </form>


            </div>

            <div class="col-md-12" style="margin-top: 20px;">
                <table id="provider-table" class="table table-bordred table-striped">
                    <thead>
                    <th></th>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Fun&ccedil;&atilde;o</th>
                    <th>Data de contrata&ccedil;&atilde;o</th>
                    <th></th>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>

<!-- /page content -->
@endsection
