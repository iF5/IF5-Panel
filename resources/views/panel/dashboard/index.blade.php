@extends('layouts.panel')

@section('title', 'Dashboard')

@section('content')
        <!-- page content -->

<div class="right_col" role="main">
    <div class="row">
        <div class="x_panel">
            <div class="x_title">
                <!-- menu breadcrumb -->
                @include('includes.breadcrumb')
            </div>

            <div class="col-md-6"></div>

            <div class="col-md-12" style="overflow-x: auto; min-height: 350px;">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>
                            <div>Cliente 1</div>
                        </th>
                        <th>
                            <div style="width: 200px; text-align: center;">
                                <i class="material-icons" style="font-size:30px;color:red;">error</i>
                            </div>
                        </th>
                        <th>
                            <div style="width: 200px; text-align: center;">
                                <a href="#">
                                    <i class="material-icons" style="font-size:30px;color:yellow;">warning</i>
                                </a>
                            </div>
                        </th>
                        <th>
                            <div style="width: 200px; text-align: center;">
                                <a href="#">
                                    <i class="material-icons" style="font-size:30px;color:green">check</i>
                                </a>
                            </div>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                          <td>
                              Próprios
                          </td>
                          <td>
                            <div style="text-align: center;"> 10 </div>
                          </td>
                          <td>
                            <div style="text-align: center;"> 10 </div>

                            </div>
                          </td>
                          <td>
                            <div style="text-align: center;"> 10 </div>
                          </td>
                        </tr>
                        <tr>
                          <td>
                              Prestadores
                          </td>
                          <td>
                            <div style="text-align: center;"> 10 </div>
                          </td>
                          <td>
                            <div style="text-align: center;"> 10 </div>

                            </div>
                          </td>
                          <td>
                            <div style="text-align: center;"> 10 </div>
                          </td>
                        </tr>
                        <tr>
                          <td>
                              Funcionários
                          </td>
                          <td>
                            <div style="text-align: center;"> 10 </div>
                          </td>
                          <td>
                            <div style="text-align: center;"> 10 </div>

                            </div>
                          </td>
                          <td>
                            <div style="text-align: center;"> 10 </div>
                          </td>
                        </tr>
                    </tbody>
                </table>

                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>
                            <div>Cliente 2</div>
                        </th>
                        <th>
                            <div style="width: 200px; text-align: center;">
                                <i class="material-icons" style="font-size:30px;color:red;">error</i>
                            </div>
                        </th>
                        <th>
                            <div style="width: 200px; text-align: center;">
                                <a href="#">
                                    <i class="material-icons" style="font-size:30px;color:yellow;">warning</i>
                                </a>
                            </div>
                        </th>
                        <th>
                            <div style="width: 200px; text-align: center;">
                                <a href="#">
                                    <i class="material-icons" style="font-size:30px;color:green">check</i>
                                </a>
                            </div>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                          <td>
                              Próprios
                          </td>
                          <td>
                            <div style="text-align: center;"> 10 </div>
                          </td>
                          <td>
                            <div style="text-align: center;"> 10 </div>

                            </div>
                          </td>
                          <td>
                            <div style="text-align: center;"> 10 </div>
                          </td>
                        </tr>
                        <tr>
                          <td>
                              Prestadores
                          </td>
                          <td>
                            <div style="text-align: center;"> 10 </div>
                          </td>
                          <td>
                            <div style="text-align: center;"> 10 </div>

                            </div>
                          </td>
                          <td>
                            <div style="text-align: center;"> 10 </div>
                          </td>
                        </tr>
                        <tr>
                          <td>
                              Funcionários
                          </td>
                          <td>
                            <div style="text-align: center;"> 10 </div>
                          </td>
                          <td>
                            <div style="text-align: center;"> 10 </div>

                            </div>
                          </td>
                          <td>
                            <div style="text-align: center;"> 10 </div>
                          </td>
                        </tr>
                    </tbody>
                </table>

                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>
                            <div>Cliente 3</div>
                        </th>
                        <th>
                            <div style="width: 200px; text-align: center;">
                                <i class="material-icons" style="font-size:30px;color:red;">error</i>
                            </div>
                        </th>
                        <th>
                            <div style="width: 200px; text-align: center;">
                                <a href="#">
                                    <i class="material-icons" style="font-size:30px;color:yellow;">warning</i>
                                </a>
                            </div>
                        </th>
                        <th>
                            <div style="width: 200px; text-align: center;">
                                <a href="#">
                                    <i class="material-icons" style="font-size:30px;color:green">check</i>
                                </a>
                            </div>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                          <td>
                              Próprios
                          </td>
                          <td>
                            <div style="text-align: center;"> 10 </div>
                          </td>
                          <td>
                            <div style="text-align: center;"> 10 </div>

                            </div>
                          </td>
                          <td>
                            <div style="text-align: center;"> 10 </div>
                          </td>
                        </tr>
                        <tr>
                          <td>
                              Prestadores
                          </td>
                          <td>
                            <div style="text-align: center;"> 10 </div>
                          </td>
                          <td>
                            <div style="text-align: center;"> 10 </div>

                            </div>
                          </td>
                          <td>
                            <div style="text-align: center;"> 10 </div>
                          </td>
                        </tr>
                        <tr>
                          <td>
                              Funcionários
                          </td>
                          <td>
                            <div style="text-align: center;"> 10 </div>
                          </td>
                          <td>
                            <div style="text-align: center;"> 10 </div>

                            </div>
                          </td>
                          <td>
                            <div style="text-align: center;"> 10 </div>
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
