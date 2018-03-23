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

                    <form class="v-form">

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control v-void" id="name"
                                       placeholder="D&ecirc; um nome para o lote">
                            </div>
                            <div class="form-group col-md-3">
                                <select id="delimiter" class="form-control v-void">
                                    <option value="">Informe o delimitador do csv</option>
                                    <option value=";">; Ponto e v&iacute;rgula</option>
                                    <option value=",">, V&iacute;rgula</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <button type="submit" class="btn btn-success">Cadastrar lote</button>
                            </div>

                        </div>

                    </form>


                </div>

                <div class="col-md-12" style="margin-top: 20px;">
                    <table id="provider-table" class="table table-bordred table-striped">
                        <thead>
                        <th>Nome</th>
                        <th>Delimitador csv</th>
                        <th>Arquivo</th>
                        <th>Status</th>
                        <th>Cadastrado em</th>
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
