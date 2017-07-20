@extends('layouts.panel')

@section('title', 'Gest&atilde;o de log')

@section('content')
        <!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <div class="x_panel">
            <div class="x_title">
                <!-- menu breadcrumb -->
            </div>

            <div class="col-md-6">
            </div>
            <div class="col-md-6"></div>

            <div class="col-md-12" style="overflow-x: auto; min-height: 350px;">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>
                            <div>Prestador</div>
                        </th>
                        <th>CNDs</th>
                        <th>Funcion&aacute;rios</th>
                        <th>Guias pagas</th>
                        <th>Prestador de servi&ccedil;os</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>prestador 01</td>
                            <td>
                                <span style="float: left; padding: 0 5px 0 0">1/10</span>
                                <span style="float: left; height: 18px; width: 10px; background: #169F85;"></span>
                            </td>
                            <td>
                                <span style="float: left; padding: 0 5px 0 0">5/10</span>
                                <span style="float: left; height: 18px; width: 50px; background: #169F85;"></span>
                            </td>
                            <td>
                                <span style="float: left; padding: 0 5px 0 0">8/10</span>
                                <span style="float: left; height: 18px; width: 80px; background: #169F85;"></span>
                            </td>
                            <td>
                                <span style="float: left; padding: 0 5px 0 0">3/10</span>
                                <span style="float: left; height: 18px; width: 30px; background: #169F85;"></span>
                            </td>
                        </tr>
                        <tr>
                            <td>prestador 02</td>
                            <td>
                                <span style="float: left; padding: 0 5px 0 0">5/10</span>
                                <span style="float: left; height: 18px; width: 50px; background: #169F85;"></span>
                            </td>
                            <td>
                                <span style="float: left; padding: 0 5px 0 0">2/10</span>
                                <span style="float: left; height: 18px; width: 20px; background: #169F85;"></span>
                            </td>
                            <td>
                                <span style="float: left; padding: 0 5px 0 0">4/10</span>
                                <span style="float: left; height: 18px; width: 40px; background: #169F85;"></span>
                            </td>
                            <td>
                                <span style="float: left; padding: 0 5px 0 0">9/10</span>
                                <span style="float: left; height: 18px; width: 90px; background: #169F85;"></span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- /page content -->
@endsection
