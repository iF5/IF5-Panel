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
              @if (count($companies) < 1)
                    <div class="alert alert-warning" role="alert">
                        <h4 class="alert-heading">Atenção!</h4>
                        <p>Não há clientes cadastrados, é necessário que cadastre pelo menos 1 pra que as informações sejam apresentadas no Dashboard.</p>
                        <hr>
                        <p class="mb-0"><a href="/company/create" class="btn btn-warning">Adicionar novo cliente</a>
                        </p>
                    </div>
              @endif

              @foreach($companies as $key => $company)
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>
                            <div>{{ $company['name'] }}</div>
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
                            <div style="text-align: center;">
                                @if(array_key_exists($key, $documentCompanies))
                                  @if(array_key_exists($PENDING_UPLOAD, $documentCompanies[$key]))
                                      {{ count($documentCompanies[$key][0]) }}
                                  @else
                                      {{ 0 }}
                                  @endif
                                @endif
                            </div>
                          </td>
                          <td>
                            <div style="text-align: center;">
                              @if(array_key_exists($key, $documentCompanies))
                                @if(array_key_exists($PENDING_APPROVAL, $documentCompanies[$key]))
                                    {{ count($documentCompanies[$key][1]) }}
                                @else
                                    {{ 0 }}
                                @endif
                              @endif
                            </div>
                          </td>
                          <td>
                            <div style="text-align: center;">
                              @if(array_key_exists($key, $documentCompanies))
                                @if(array_key_exists($APPROVED, $documentCompanies[$key]))
                                    {{ count($documentCompanies[$key][2]) }}
                                @else
                                    {{ 0 }}
                                @endif
                              @endif
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td>
                              Prestadores
                          </td>
                          <td>
                            <div style="text-align: center;">
                              @if(array_key_exists($key, $documentProviders))
                                @if(array_key_exists($PENDING_UPLOAD, $documentProviders[$key]))
                                    {{ count($documentProviders[$key][0]) }}
                                @else
                                    {{ 0 }}
                                @endif
                              @endif
                            </div>
                          </td>
                          <td>
                            <div style="text-align: center;">
                              @if(array_key_exists($key, $documentProviders))
                                @if(array_key_exists($PENDING_APPROVAL, $documentProviders[$key]))
                                    {{ count($documentProviders[$key][1]) }}
                                @else
                                    {{ 0 }}
                                @endif
                              @endif
                            </div>
                          </td>
                          <td>
                            <div style="text-align: center;">
                              @if(array_key_exists($key, $documentProviders))
                                @if(array_key_exists($APPROVED, $documentProviders[$key]))
                                    {{ count($documentProviders[$key][2]) }}
                                @else
                                    {{ 0 }}
                                @endif
                              @endif
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td>
                              Funcionários
                          </td>
                          <td>
                            <div style="text-align: center;">
                              @if(array_key_exists($key, $documentEmployees))
                                @if(array_key_exists($PENDING_UPLOAD, $documentEmployees[$key]))
                                    {{ count($documentEmployees[$key][0]) }}
                                @else
                                    {{ 0 }}
                                @endif
                              @endif
                            </div>
                          </td>
                          <td>
                            <div style="text-align: center;">
                              @if(array_key_exists($key, $documentEmployees))
                                @if(array_key_exists($PENDING_APPROVAL, $documentEmployees[$key]))
                                    {{ count($documentEmployees[$key][1]) }}
                                @else
                                    {{ 0 }}
                                @endif
                              @endif
                            </div>
                          </td>
                          <td>
                            <div style="text-align: center;">
                              @if(array_key_exists($key, $documentEmployees))
                                @if(array_key_exists($APPROVED, $documentEmployees[$key]))
                                    {{ count($documentEmployees[$key][2]) }}
                                @else
                                    {{ 0 }}
                                @endif
                              @endif
                            </div>
                          </td>
                        </tr>
                    </tbody>
                </table>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- /page content -->
@endsection
