@extends('layouts.panel')

@section('title', 'Empresa/Prestador')

@section('content')
        <!-- page content -->
<div class="right_col" role="main">

    <div class="row">
        <div class="x_panel">
            <div class="x_title">
                <!-- menu breadcrumb -->
                @include('includes.breadcrumb')
            </div>

            <div class="col-md-3">
                <form action=""
                      method="get">
                    <div class="input-group">
                        @if($referenceDate)
                            <span class="input-group-addon">
                                <a href="{{ route('checklist.company.index', ['periodicity' => $periodicity]) }}"
                                   title="Limpar busca">
                                    <i class="glyphicon glyphicon-remove"></i>
                                </a>
                            </span>
                        @endif
                        <input class="form-control referenceDate" type="text" name="referenceDate"
                               title="Data Referencia - Mes e Ano" placeholder="mm/aaaa"
                               value="" required>
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i>
                                </button>
                            </span>
                    </div>
                </form>
                <div class="clearfix"></div>
            </div>

            <div class="col-md-12">
                <div class="clearfix"></div>
            </div>

            <div class="col-md-16">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs">
                    @foreach($periodicities as $key => $value)
                        <li @if($key === $periodicity) class="active" @endif>
                            <a href="{{route('checklist.company.index', ['periodicity' => $key])}}">{{ $value }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="col-md-16">

                <input type="hidden" id="periodicity" value="{{ $periodicity }}"/>

                <!-- Tab panes -->
                <table id="checklist-table" class="table table-bordred table-striped">
                    <thead>
                    <th></th>
                    <th>Documento</th>
                    <th>Data de refer&ecirc;ncia</th>
                    <th>Validade</th>
                    <th>Status</th>
                    <th>A&ccedil;&atilde;o</th>
                    </thead>
                    <tbody>
                    @forelse($documents as $document)
                        <tr>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
                                        <span class='glyphicon glyphicon-cog'></span> <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <a href="">Aprovar</a>
                                        </li>
                                        <li>
                                            <a href="" data-toggle="modal">Reprovar</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                            <td width="30%">
                                {{ $document->name }}
                            </td>
                            <td>
                                <input class="referenceDate" id="referenceDate{{ $document->id }}" name="referenceDate"
                                       title="M&ecirc;s e Ano"
                                       style="text-align: center; width: 50%;" value="" placeholder="mm/aaaa">
                            </td>
                            <td>
                                <input class="" id="validity{{ $document->id }}" name="validity"
                                       title="M&ecirc;s e Ano"
                                       style="text-align: center; width: 30%;" value="{{ $document->validity }}">
                            </td>
                            <td width="20%">
                                <!-- 1 = enviado, 2 = aprovado, 3 = reprovado -->
                                Aguardando envio

                                <a href="" class="document-read-more" title="Leia mais">
                                    <span class="glyphicon glyphicon-info-sign"></span>
                                </a>

                                <div>
                                    Enviado em : 08/09/2017 <br />
                                    Enviado em : 08/09/2017 <br />
                                    Enviado em : 08/09/2017 <br />
                                    Enviado em : 08/09/2017 <br />
                                </div>
                            </td>

                            <!-- data-toggle="modal"
                                   data-target="#upload" -->
                            <td>
                                <a href=""
                                   class="btn {{ ($document->status < 1) ? 'btn-success' : 'btn-warning' }} btn-md modal-document-upload"
                                   rel="{{ $document->id }}"
                                   title="Enviar documento">
                                    {{ ($document->status < 1) ? 'Enviar' : 'Reenviar' }}
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" align="center">Nenhum documento foi encontrado.</td>
                        </tr>
                    @endforelse

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- /page content -->
@endsection
