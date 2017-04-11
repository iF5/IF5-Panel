@extends('layouts.panel')

@section('title', 'Empresa/Prestador')

@section('content')
        <!-- page content -->
<div class="right_col" role="main">

    <div class="row">
        <div class="x_panel">
            <div class="x_title">
                <h2>Checklist
                    <span class="text-primary">Upload/Download de documentos</span>
                </h2>
                <div class="clearfix"></div>
            </div>

            <div class="col-md-16">

                <div>

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="{{$activeMontly}}"><a href="#montly" aria-controls="montly" role="tab" data-toggle="tab">Mensal</a></li>
                        <li role="presentation" class="{{$activeYearly}}"><a href="#yearly" aria-controls="yearly" role="tab" data-toggle="tab">Anual</a></li>
                        <li role="presentation" class="{{$activeSolicited}}"><a href="#solicited" aria-controls="solicited" role="tab" data-toggle="tab">Quando solicitado</a></li>
                        <li role="presentation" class="{{$activeHomologated}}"><a href="#homologated" aria-controls="homologated" role="tab" data-toggle="tab">Homologaçao</a></li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="montly">
                            <div class="table-responsive">
                                <table id="checklist-table" class="table table-bordred table-striped">
                                    <thead>
                                    <th>{{ucfirst($employee_name)}}</th>
                                    <th>Status</th>
                                    <th>Referencia</th>
                                    <th>Envio</th>
                                    <th>Processado</th>
                                    <th>Validado</th>
                                    <th>A&ccedil;&otilde;es</th>
                                    </thead>
                                    <tbody>
                                    @foreach($documents as $docs)
                                        <tr>
                                            <td>{{$docs->name}}</td>
                                            <td>
                                                @if ($docs->status == 1)
                                                    Enviado
                                                @elseif ($docs->status == 2)
                                                    Reenviar
                                                @else
                                                    Pendente
                                                @endif
                                            </td>
                                            <td>
                                                @if ($docs->referenceDate)
                                                    {{date('d/m/Y', strtotime($docs->referenceDate))}}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($docs->sendDate)
                                                    {{date('d/m/Y H:i', strtotime($docs->sendDate))}}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($docs->receivedDate)
                                                    {{date('d/m/Y H:i', strtotime($docs->receivedDate))}}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($docs->validated == 1)
                                                    Sim
                                                @else
                                                    Nao
                                                @endif
                                            </td>
                                            <td>

                                                @if ($docs->validated == 1)
                                                    Baixar
                                                @else
                                                    Enviar
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="yearly">
                            b
                        </div>
                        <div role="tabpanel" class="tab-pane" id="solicited">
                            c
                        </div>
                        <div role="tabpanel" class="tab-pane" id="homologated">
                            d
                        </div>
                    </div>

                </div>


                <div class="table-responsive">


                    <div class="clearfix"></div>

                    <div class="col-md-16">As ações abaixo agendarão a compactação dos arquivos e deixará disponivel no
                        repositório para download.
                    </div>
                    <div class="col-md-16" style="margin-top: 20px;">Baixar todos os documentos de {{$employee_name}} <a
                                class="btn btn-primary" href="#"> Baixar tudo</a></div>

                </div>
            </div>
        </div>
    </div>

    <!-- /page content -->
@endsection
