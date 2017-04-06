@extends('layouts.panel')

@section('title', 'Empresa/Prestador')

@section('content')
        <!-- page content -->
<div class="right_col" role="main">

    <div class="row">
        <div class="x_panel">
            <div class="x_title">
                <h2>Checklist
                    <span class="text-primary">Upload/Download de arquivos</span>
                </h2>
                <div class="clearfix"></div>
            </div>

            <div class="col-md-12">
                <div class="table-responsive">

                    <div class="table-responsive">
                        <table id="checklist-table" class="table table-bordred table-striped">
                            <thead>
                            <th>{{ucfirst($employee_name)}}</th>
                            <th>Status</th>
                            <th>Envio</th>
                            <th>Processado</th>
                            <th>Validado</th>
                            <th>A&ccedill;&otilde;es</th>
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
                                <td>{{$docs->sendDate}}</td>
                                <td>{{$docs->receivedDate}}</td>
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
                    <div class="clearfix"></div>

                    <div class="col-md-12">As ações abaixo agendarão a compactação dos arquivos e deixará disponivel no
                        repositório para download.
                    </div>
                    <div class="col-md-12" style="margin-top: 20px;">Baixar todos os documentos de {{$employee_name}} <a
                                class="btn btn-primary" href="#"> Baixar tudo</a></div>

                </div>
            </div>
        </div>
    </div>

    <!-- /page content -->
@endsection
