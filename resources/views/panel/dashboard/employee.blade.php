@extends('layouts.panel')

@section('title', 'Funcion&aacute;rios')

@section('content')
        <!-- page content -->
<div class="right_col" role="main">

    <div class="row">
        <div class="x_panel">
            <div class="x_title">
                <h2>Dashboard
                    <span class="text-primary">Funcion&aacute;rios</span>
                </h2>
                <div class="clearfix"></div>
            </div>
            <div class="col-md-12">
                <div class="table-responsive">
                    <div class="col-md-6">
                        <form action="#" method="post">
                            <div class="input-group">
                                <input class="form-control" id="system-search" name="company"
                                       placeholder="Buscar por funcion&aacute;rio"
                                       required>
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i>
                        </button>
                    </span>
                            </div>
                        </form>
                    </div>

                    <div class="col-md-6"></div>
                    <div class="clearfix"></div>
                    <div class="table-responsive">
                        <table id="employee-table" class="table table-bordred table-striped">
                            <thead>
                            <th>Brasanitas</th>
                            <th>Doc A</th>
                            <th>Doc B</th>
                            <th>Doc C</th>
                            <th>Doc D</th>
                            <th>Doc E</th>
                            <th>Doc F</th>
                            <th>Doc G</th>
                            <th>Doc H</th>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Funcionario A</td>
                                <td><i class="fa fa-check"></i></td>
                                <td><i class="fa fa-check"></i></td>
                                <td><i class="fa fa-check"></i></td>
                                <td><i class="fa fa-check"></i></td>
                                <td></td>
                                <td><i class="fa fa-check"></i></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Funcionario B</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Funcionario C</td>
                                <td><i class="fa fa-check"></i></td>
                                <td></td>
                                <td><i class="fa fa-check"></i></td>
                                <td><i class="fa fa-check"></i></td>
                                <td></td>
                                <td><i class="fa fa-check"></i></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Funcionario D</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Funcionario E</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>

                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <!-- /page content -->
@endsection
