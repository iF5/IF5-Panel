@extends('layouts.panel')

@section('title', 'Gest&atilde;o de prestador de servi&ccedil;os')

@section('content')
    <!-- page content -->

    <div class="right_col" role="main">

        <div class="row">
            <div class="x_panel">
                <div class="x_title">
                    <!-- menu breadcrumb -->
                    @include('includes.breadcrumb')
                </div>

                <ul class="list-group">
                    <li class="list-group-item"><strong>Nome : </strong> {{ $provider->name }}</li>
                    <li class="list-group-item"><strong>Nome Fantasia : </strong> {{ $provider->fantasyName }}</li>
                    <li class="list-group-item"><strong>Ramo de Atividade : </strong> {{ $provider->activityBranch }}
                    </li>


                    <li class="list-group-item"><strong>CNPJ : </strong> {{ $provider->cnpj }}</li>
                    <li class="list-group-item"><strong>Inscrição Estadual : </strong> {{ $provider->stateInscription }}
                    </li>
                    <li class="list-group-item"><strong>Inscrição Municipal
                            : </strong> {{ $provider->municipalInscription }}
                    </li>

                    <li class="list-group-item"><strong>CNAE Principal : </strong> {{ $provider->mainCnae }}</li>
                    <li class="list-group-item"><strong>Telefone : </strong> {{ $provider->phone }}</li>
                    <li class="list-group-item"><strong>Fax : </strong> {{ $provider->fax }}</li>

                    <li class="list-group-item"><strong>CEP : </strong> {{ $provider->cep }}</li>
                    <li class="list-group-item"><strong>Logradouro : </strong> {{ $provider->street }}</li>
                    <li class="list-group-item"><strong>Número : </strong> {{ $provider->number }}</li>

                    <li class="list-group-item"><strong>Bairro : </strong> {{ $provider->district }}</li>
                    <li class="list-group-item"><strong>Cidade : </strong> {{ $provider->city }}</li>
                    <li class="list-group-item"><strong>UF : </strong> {{ $provider->state }}</li>

                    <li class="list-group-item"><strong>Nome responsável : </strong> {{ $provider->responsibleName }}
                    </li>
                    <li class="list-group-item"><strong>Celular: </strong> {{ $provider->cellPhone }}</li>
                    <li class="list-group-item"><strong>E-mail: </strong> {{ $provider->email }}</li>
                    
                    <li class="list-group-item"><strong>Status
                            : </strong> {{ ($provider->status)? 'Ok' : 'Aguardando aprovação' }}</li>
                    <li class="list-group-item"><strong>Cadastrado em
                            : </strong> {{ \Carbon\Carbon::parse($provider->createdAt)->format('d/m/Y H:i:s') }}</li>
                    <li class="list-group-item"><strong>&Uacute;ltima atualiza&ccedil;&atilde;o
                            : </strong> {{ \Carbon\Carbon::parse($provider->updatedAt)->format('d/m/Y H:i:s') }}</li>
                    <li class="list-group-item">
                        @if(!$provider->status && \Auth::user()->role === 'admin')
                            <a href="#"
                               class="btn btn-success btn-md modal-update" title="Aprovar"
                               data-toggle="modal"
                               data-target="#update"
                               rel="{{ route('pendency.approve', ['companyId' => $provider->companyId, 'id' => $provider->id, 'source' => 'provider']) }}"
                               rev="Tem certeza que deseja aprovar este registro?"><span
                                        class="glyphicon glyphicon-thumbs-up"></span></a>
                        @endif
                        @can('onlyAdmin')
                            <a href="{{ route('provider.edit', $provider->id) }}"
                               class="btn btn-success btn-md"><span
                                        class="glyphicon glyphicon-pencil"></span></a>
                        @endcan

                        <a href="#"
                           class="btn btn-danger btn-md modal-delete" data-title="Excluir"
                           data-toggle="modal"
                           data-target="#delete"
                           rel="{{ route('provider.destroy', $provider->id) }}"><span
                                    class="glyphicon glyphicon-trash"></span></a>

                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- /page content -->
@endsection
