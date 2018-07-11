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

            @if ($role == 'admin')
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
                            <th>{{ $company['name'] }}</th>
                            <th style="text-align: center;">
                                <i class="material-icons" style="font-size:30px;color:red;">error</i>
                            </th>
                            <th style="text-align: center;">
                                <a href="#"><i class="material-icons" style="font-size:30px;color:yellow;">warning</i></a>
                            </th>
                            <th style="text-align: center;">
                                <a href="#"><i class="material-icons" style="font-size:30px;color:green">check</i></a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><a href="/checklist-company/{{ $key }}">Próprios</a></td>
                            <td style="text-align: center;">
                                @if(array_key_exists($key, $documentCompanies))
                                  @if(array_key_exists($PENDING_UPLOAD, $documentCompanies[$key]))
                                      {{ count($documentCompanies[$key][0]) }}
                                  @else
                                      0
                                  @endif
                                @else
                                    0
                                @endif
                            </td>
                            <td style="text-align: center;">
                              @if(array_key_exists($key, $documentCompanies))
                                @if(array_key_exists($PENDING_APPROVAL, $documentCompanies[$key]))
                                    {{ count($documentCompanies[$key][1]) }}
                                @else
                                    0
                                @endif
                              @else
                                  0
                              @endif
                            </td>
                            <td style="text-align: center;">
                              @if(array_key_exists($key, $documentCompanies))
                                @if(array_key_exists($APPROVED, $documentCompanies[$key]))
                                    {{ count($documentCompanies[$key][2]) }}
                                @else
                                    0
                                @endif
                              @else
                                  0
                              @endif
                            </td>
                        </tr>
                        <tr>
                            <td><a href="/provider/{{ $key }}/identify">Prestadores</a></td>
                          <td style="text-align: center;">
                              @if(array_key_exists($key, $documentProviders))
                                @if(array_key_exists($PENDING_UPLOAD, $documentProviders[$key]))
                                    {{ count($documentProviders[$key][0]) }}
                                @else
                                    0
                                @endif
                              @else
                                0
                              @endif
                          </td>
                          <td style="text-align: center;">
                              @if(array_key_exists($key, $documentProviders))
                                @if(array_key_exists($PENDING_APPROVAL, $documentProviders[$key]))
                                    {{ count($documentProviders[$key][1]) }}
                                @else
                                    0
                                @endif
                              @else
                                0
                              @endif
                          </td>
                          <td style="text-align: center;">
                              @if(array_key_exists($key, $documentProviders))
                                @if(array_key_exists($APPROVED, $documentProviders[$key]))
                                    {{ count($documentProviders[$key][2]) }}
                                @else
                                    0
                                @endif
                              @else
                                0
                              @endif
                          </td>
                        </tr>
                        <tr>
                            <td><a href="/provider/{{ $key }}/identify">Funcionários</a></td>
                          <td style="text-align: center;">
                              @if(array_key_exists($key, $documentEmployees))
                                @if(array_key_exists($PENDING_UPLOAD, $documentEmployees[$key]))
                                    {{ count($documentEmployees[$key][0]) }}
                                @else
                                    0
                                @endif
                              @else
                                0
                              @endif
                          </td>
                          <td style="text-align: center;">
                              @if(array_key_exists($key, $documentEmployees))
                                @if(array_key_exists($PENDING_APPROVAL, $documentEmployees[$key]))
                                    {{ count($documentEmployees[$key][1]) }}
                                @else
                                    0
                                @endif
                              @else
                                0
                              @endif
                          </td>
                          <td style="text-align: center;">
                              @if(array_key_exists($key, $documentEmployees))
                                @if(array_key_exists($APPROVED, $documentEmployees[$key]))
                                    {{ count($documentEmployees[$key][2]) }}
                                @else
                                    0
                                @endif
                              @else
                                0
                              @endif
                          </td>
                        </tr>
                    </tbody>
                </table>
                @endforeach
            </div>
            @elseif($role == 'company')
            <div class="col-md-12" style="overflow-x: auto;">
                @if (!$company)
                    <div class="alert alert-warning" role="alert">
                        <h4 class="alert-heading">Atenção!</h4>
                        <p>Não há clientes cadastrados, é necessário que cadastre pelo menos 1 pra que as informações sejam apresentadas no Dashboard.</p>
                        <hr>
                        <p class="mb-0"><a href="/company/create" class="btn btn-warning">Adicionar novo cliente</a>
                        </p>
                    </div>
                @endif
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>{{ $company['name'] }}</th>
                            <th style="text-align: center;">
                                <i class="material-icons" style="font-size:30px;color:red;">error</i>
                            </th>
                            <th style="text-align: center;">
                                <a href="#"><i class="material-icons" style="font-size:30px;color:yellow;">warning</i></a>
                            </th>
                            <th style="text-align: center;">
                                <a href="#"><i class="material-icons" style="font-size:30px;color:green">check</i></a>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><a href="#">Próprios</a></td>
                            <td style="text-align: center;">
                                @if(array_key_exists($company['id'], $documentsCompany))
                                    @if(array_key_exists($PENDING_UPLOAD, $documentsCompany[$company['id']]))
                                        {{ count($documentsCompany[$company['id']][0]) }}
                                    @else
                                        0
                                    @endif
                                @else
                                    0
                                @endif
                            </td>
                            <td style="text-align: center;">
                                @if(array_key_exists($company['id'], $documentsCompany))
                                    @if(array_key_exists($PENDING_APPROVAL, $documentsCompany[$company['id']]))
                                        {{ count($documentsCompany[$company['id']][1]) }}
                                    @else
                                        0
                                    @endif
                                @else
                                    0
                                @endif
                            </td>
                            <td style="text-align: center;">
                                @if(array_key_exists($company['id'], $documentsCompany))
                                    @if(array_key_exists($APPROVED, $documentsCompany[$company['id']]))
                                        {{ count($documentsCompany[$company['id']][2]) }}
                                    @else
                                        0
                                    @endif
                                @else
                                    0
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><a href="/provider">Prestadores</a></td>
                            <td style="text-align: center;">
                                @if(array_key_exists($company['id'], $documentProviders))
                                    @if(array_key_exists($PENDING_UPLOAD, $documentProviders[$company['id']]))
                                        {{ count($documentProviders[$company['id']][0]) }}
                                    @else
                                        0
                                    @endif
                                @else
                                    0
                                @endif
                            </td>
                            <td style="text-align: center;">
                                @if(array_key_exists($company['id'], $documentProviders))
                                    @if(array_key_exists($PENDING_APPROVAL, $documentProviders[$company['id']]))
                                        {{ count($documentProviders[$company['id']][1]) }}
                                    @else
                                        0
                                    @endif
                                @else
                                    0
                                @endif
                            </td>
                            <td style="text-align: center;">
                                @if(array_key_exists($company['id'], $documentProviders))
                                    @if(array_key_exists($APPROVED, $documentProviders[$company['id']]))
                                        {{ count($documentProviders[$company['id']][2]) }}
                                    @else
                                        0
                                    @endif
                                @else
                                    0
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><a href="#">Funcionários</a></td>
                            <td style="text-align: center;">
                                @if(array_key_exists($company['id'], $documentEmployees))
                                    @if(array_key_exists($PENDING_UPLOAD, $documentEmployees[$company['id']]))
                                        {{ count($documentEmployees[$company['id']][0]) }}
                                    @else
                                        0
                                    @endif
                                @else
                                    0
                                @endif
                                </div>
                            </td>
                            <td style="text-align: center;">
                                @if(array_key_exists($company['id'], $documentEmployees))
                                    @if(array_key_exists($PENDING_APPROVAL, $documentEmployees[$company['id']]))
                                        {{ count($documentEmployees[$company['id']][1]) }}
                                    @else
                                        0
                                    @endif
                                @else
                                    0
                                @endif
                            </td>
                            <td style="text-align: center;">
                                @if(array_key_exists($company['id'], $documentEmployees))
                                    @if(array_key_exists($APPROVED, $documentEmployees[$company['id']]))
                                        {{ count($documentEmployees[$company['id']][2]) }}
                                    @else
                                        0
                                    @endif
                                @else
                                    0
                                @endif
                            </td>
                        </tr>
                        </tbody>
                    </table>
                
            </div>


            <div class="col-md-12" style="overflow-x: auto;">
                <h5 style="font-weight: bold;">PRESTADORES DE SERVIÇOS</h5>
                @foreach($providers as $key => $provider)
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>{{ $provider['name'] }}</th>
                            <th style="text-align: center;">
                                <i class="material-icons" style="font-size:30px;color:red;">error</i>
                            </th>
                            <th style="text-align: center;">
                                <a href="#"><i class="material-icons" style="font-size:30px;color:yellow;">warning</i></a>
                            </th>
                            <th style="text-align: center;">
                                <a href="#"><i class="material-icons" style="font-size:30px;color:green">check</i></a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><a href="/provider/{{ $key }}/identify">Prestador</a></td>
                            <td>
                                @if(array_key_exists($key, $documentProviders))
                                    @if(array_key_exists($PENDING_UPLOAD, $documentProviders[$key]))
                                        {{ count($documentProviders[$key][0]) }}
                                    @else
                                        0
                                    @endif
                                @else
                                    0
                                @endif
                            </td>
                            <td>
                                @if(array_key_exists($key, $documentProviders))
                                    @if(array_key_exists($PENDING_APPROVAL, $documentProviders[$key]))
                                        {{ count($documentProviders[$key][1]) }}
                                    @else
                                        0
                                    @endif
                                @else
                                    0
                                @endif
                            </td>
                            <td>
                                @if(array_key_exists($key, $documentProviders))
                                    @if(array_key_exists($APPROVED, $documentProviders[$key]))
                                        {{ count($documentProviders[$key][2]) }}
                                    @else
                                        0
                                    @endif
                                @else
                                    0
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><a href="#">Funcionários</a></td>
                            <td>
                                @if(array_key_exists($company['id'], $documentEmployees))
                                    @if(array_key_exists($PENDING_UPLOAD, $documentEmployees[$company['id']][$key]))
                                        {{ count($documentEmployees[$company['id']][$key][0]) }}
                                    @else
                                        0
                                    @endif
                                @else
                                    0
                                @endif
                            </td>
                            <td>
                                @if(array_key_exists($company['id'], $documentEmployees))
                                    @if(array_key_exists($PENDING_APPROVAL, $documentEmployees[$company['id']][$key]))
                                        {{ count($documentEmployees[$company['id']][$key][1]) }}
                                    @else
                                        0
                                    @endif
                                @else
                                    0
                                @endif
                            </td>
                            <td>
                                @if(array_key_exists($company['id'], $documentEmployees))
                                    @if(array_key_exists($APPROVED, $documentEmployees[$company['id']][$key]))
                                        {{ count($documentEmployees[$company['id']][$key][2]) }}
                                    @else
                                        0
                                    @endif
                                @else
                                    0
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
                @endforeach
            </div>
            @elseif($role == 'provider')
                <h1>provider</h1>
            @endif
        </div>
    </div>
</div>

<!-- /page content -->
@endsection
