@extends('panel.layout')

@section('title', 'Empresa/Prestador')

@section('content')
        <!-- page content -->
<div class="right_col" role="main">

    <div class="row">
        <div class="x_panel">
            <div class="x_title">
                <h2>Dashboard
                    <span class="text-primary">Empresa/Prestador</span>
                </h2>
                <div class="clearfix"></div>
            </div>


            <!--
            <div class="col-xs-6 col-md-4">.col-xs-6 .col-md-4</div>
            <div class="col-xs-6 col-md-4">.col-xs-6 .col-md-4</div>
            -->
            <div class="col-md-12">
                <div class="table-responsive">
                    <table id="provider-table" class="table table-bordred table-striped">
                        <thead>
                        <th>Prestador</th>
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
                            <td>Brasanitas</td>
                            <td>10/10</td>
                            <td>10/10</td>
                            <td>10/10</td>
                            <td>10/10</td>
                            <td>10/10</td>
                            <td>10/10</td>
                            <td>10/10</td>
                            <td>10/10</td>
                        </tr>
                        <tr>
                            <td>SOS</td>
                            <td>10/10</td>
                            <td>10/10</td>
                            <td>10/10</td>
                            <td>10/10</td>
                            <td>10/10</td>
                            <td>10/10</td>
                            <td>10/10</td>
                            <td>10/10</td>
                        </tr>
                        <tr>
                            <td>Prosegur</td>
                            <td>10/10</td>
                            <td>10/10</td>
                            <td>10/10</td>
                            <td>10/10</td>
                            <td>10/10</td>
                            <td>10/10</td>
                            <td>10/10</td>
                            <td>10/10</td>
                        </tr>

                        </tbody>
                    </table>
                </div>

                <div class="clearfix"></div>
                <div class="col-md-6">
                    <form action="#" method="post">
                        <div class="input-group">
                            <input class="form-control" id="system-search" name="company"
                                   placeholder="Buscar por empresa"
                                   required>
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i>
                        </button>
                    </span>
                        </div>
                    </form>
                </div>

                <div class="col-md-6">
                    <form action="#" method="post">
                        <div class="input-group">
                            <input class="form-control" id="system-search" name="provider"
                                   placeholder="Buscar por prestador"
                                   required>
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i>
                        </button>
                    </span>
                        </div>
                    </form>
                </div>

                <div class="clearfix" style="height:70px;"></div>

                <div class="table-responsive">
                    <table id="company-table" class="table table-bordred table-striped">
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
                            <td></td>
                            <td><i class="fa fa-check"></i></td>
                            <td></td>
                            <td></td>
                            <td><i class="fa fa-check"></i></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Funcionario B</td>
                            <td><i class="fa fa-check"></i></td>
                            <td></td>
                            <td><i class="fa fa-check"></i></td>
                            <td></td>
                            <td></td>
                            <td><i class="fa fa-check"></i></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Funcionario C</td>
                            <td><i class="fa fa-check"></i></td>
                            <td></td>
                            <td><i class="fa fa-check"></i></td>
                            <td></td>
                            <td></td>
                            <td><i class="fa fa-check"></i></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Funcionario D</td>
                            <td><i class="fa fa-check"></i></td>
                            <td></td>
                            <td><i class="fa fa-check"></i></td>
                            <td></td>
                            <td></td>
                            <td><i class="fa fa-check"></i></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Funcionario E</td>
                            <td><i class="fa fa-check"></i></td>
                            <td></td>
                            <td><i class="fa fa-check"></i></td>
                            <td></td>
                            <td></td>
                            <td><i class="fa fa-check"></i></td>
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

</div>
<!-- /page content -->
@endsection
