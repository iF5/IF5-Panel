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

              @foreach($companies as $company['id'] => $company)
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
                                @if(array_key_exists($company['id'], $documentsCompany))
                                  @if(array_key_exists($PENDING_UPLOAD, $documentsCompany[$company['id']]))
                                      {{ count($documentsCompany[$company['id']][0]) }}
                                  @endif
                                @else
                                    0
                                @endif
                            </div>
                          </td>
                          <td>
                            <div style="text-align: center;">
                              @if(array_key_exists($company['id'], $documentsCompany))
                                @if(array_key_exists($PENDING_APPROVAL, $documentsCompany[$company['id']]))
                                    {{ count($documentsCompany[$company['id']][1]) }}
                                @endif
                              @else
                                  0
                              @endif
                            </div>
                          </td>
                          <td>
                            <div style="text-align: center;">
                              @if(array_key_exists($company['id'], $documentsCompany))
                                @if(array_key_exists($APPROVED, $documentsCompany[$company['id']]))
                                    {{ count($documentsCompany[$company['id']][2]) }}
                                @endif
                              @else
                                  0
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
                              @if(array_key_exists($company['id'], $documentProviders))
                                @if(array_key_exists($PENDING_UPLOAD, $documentProviders[$company['id']]))
                                    {{ count($documentProviders[$company['id']][0]) }}
                                @endif
                              @else
                                0
                              @endif
                            </div>
                          </td>
                          <td>
                            <div style="text-align: center;">
                              @if(array_key_exists($company['id'], $documentProviders))
                                @if(array_key_exists($PENDING_APPROVAL, $documentProviders[$company['id']]))
                                    {{ count($documentProviders[$company['id']][1]) }}
                                @endif
                              @else
                                0
                              @endif
                            </div>
                          </td>
                          <td>
                            <div style="text-align: center;">
                              @if(array_key_exists($company['id'], $documentProviders))
                                @if(array_key_exists($APPROVED, $documentProviders[$company['id']]))
                                    {{ count($documentProviders[$company['id']][2]) }}
                                @endif
                              @else
                                0
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
                              @if(array_key_exists($company['id'], $documentEmployees))
                                @if(array_key_exists($PENDING_UPLOAD, $documentEmployees[$company['id']]))
                                    {{ count($documentEmployees[$company['id']][0]) }}
                                @endif
                              @else
                                0
                              @endif
                            </div>
                          </td>
                          <td>
                            <div style="text-align: center;">
                              @if(array_key_exists($company['id'], $documentEmployees))
                                @if(array_key_exists($PENDING_APPROVAL, $documentEmployees[$company['id']]))
                                    {{ count($documentEmployees[$company['id']][1]) }}
                                @endif
                              @else
                                0
                              @endif
                            </div>
                          </td>
                          <td>
                            <div style="text-align: center;">
                              @if(array_key_exists($company['id'], $documentEmployees))
                                @if(array_key_exists($APPROVED, $documentEmployees[$company['id']]))
                                    {{ count($documentEmployees[$company['id']][2]) }}
                                @endif
                              @else
                                0
                              @endif
                            </div>
                          </td>
                        </tr>
                    </tbody>
                </table>
                @endforeach
            </div>
            @elseif($role == 'company')
            <div class="col-md-12" style="overflow-x: auto; min-height: 350px;">
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
                                    @if(array_key_exists($company['id'], $documentsCompany))
                                        @if(array_key_exists($PENDING_UPLOAD, $documentsCompany[$company['id']]))
                                            {{ count($documentsCompany[$company['id']][0]) }}
                                        @endif
                                    @else
                                        0
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div style="text-align: center;">
                                    @if(array_key_exists($company['id'], $documentsCompany))
                                        @if(array_key_exists($PENDING_APPROVAL, $documentsCompany[$company['id']]))
                                            {{ count($documentsCompany[$company['id']][1]) }}
                                        @endif
                                    @else
                                        0
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div style="text-align: center;">
                                    @if(array_key_exists($company['id'], $documentsCompany))
                                        @if(array_key_exists($PENDING_APPROVAL, $documentsCompany[$company['id']]))
                                            {{ count($documentsCompany[$company['id']][2]) }}
                                        @endif
                                    @else
                                        0
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
                                    @if(array_key_exists($company['id'], $documentProviders))
                                        @if(array_key_exists($PENDING_UPLOAD, $documentProviders[$company['id']]))
                                            {{ count($documentProviders[$company['id']][0]) }}
                                        @endif
                                    @else
                                        0
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div style="text-align: center;">
                                    @if(array_key_exists($company['id'], $documentProviders))
                                        @if(array_key_exists($PENDING_APPROVAL, $documentProviders[$company['id']]))
                                            {{ count($documentProviders[$company['id']][1]) }}
                                        @endif
                                    @else
                                        0
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div style="text-align: center;">
                                    @if(array_key_exists($company['id'], $documentProviders))
                                        @if(array_key_exists($APPROVED, $documentProviders[$company['id']]))
                                            {{ count($documentProviders[$company['id']][2]) }}
                                        @endif
                                    @else
                                        0
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
                                    @if(array_key_exists($company['id'], $documentEmployees))
                                        @if(array_key_exists($PENDING_UPLOAD, $documentEmployees[$company['id']]))
                                            {{ count($documentEmployees[$company['id']][0]) }}
                                        @endif
                                    @else
                                        0
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div style="text-align: center;">
                                    @if(array_key_exists($company['id'], $documentEmployees))
                                        @if(array_key_exists($PENDING_APPROVAL, $documentEmployees[$company['id']]))
                                            {{ count($documentEmployees[$company['id']][1]) }}
                                        @endif
                                    @else
                                        0
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div style="text-align: center;">
                                    @if(array_key_exists($company['id'], $documentEmployees))
                                        @if(array_key_exists($APPROVED, $documentEmployees[$company['id']]))
                                            {{ count($documentEmployees[$company['id']][2]) }}
                                        @endif
                                    @else
                                        0
                                    @endif
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                
            </div>
            @elseif($role == 'provider')
                <h1>provider</h1>
            @endif
        </div>
    </div>
</div>

<!-- /page content -->
@endsection
