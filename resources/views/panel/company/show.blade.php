@extends('layouts.panel')

@section('title', 'Gest&atilde;o de cliente')

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
                <li class="list-group-item"><strong>Nome : </strong> {{ $company->name }}</li>
                <li class="list-group-item"><strong>Nome Fantasia : </strong> {{ $company->fantasyName }}</li>
                <li class="list-group-item"><strong>Ramo de Atividade : </strong> {{ $company->activityBranch }}</li>


                <li class="list-group-item"><strong>CNPJ : </strong> {{ $company->cnpj }}</li>
                <li class="list-group-item"><strong>Inscrição Estadual : </strong> {{ $company->stateInscription }}</li>
                <li class="list-group-item"><strong>Inscrição Municipal : </strong> {{ $company->municipalInscription }}
                </li>

                <li class="list-group-item"><strong>CNAE Principal : </strong> {{ $company->mainCnae }}</li>
                <li class="list-group-item"><strong>Telefone : </strong> {{ $company->phone }}</li>
                <li class="list-group-item"><strong>Fax : </strong> {{ $company->fax }}</li>

                <li class="list-group-item"><strong>CEP : </strong> {{ $company->cep }}</li>
                <li class="list-group-item"><strong>Logradouro : </strong> {{ $company->street }}</li>
                <li class="list-group-item"><strong>Número : </strong> {{ $company->number }}</li>

                <li class="list-group-item"><strong>Bairro : </strong> {{ $company->district }}</li>
                <li class="list-group-item"><strong>Cidade : </strong> {{ $company->city }}</li>
                <li class="list-group-item"><strong>UF : </strong> {{ $company->state }}</li>

                <li class="list-group-item"><strong>Nome responsável : </strong> {{ $company->responsibleName }}</li>
                <li class="list-group-item"><strong>Celular: </strong> {{ $company->cellPhone }}</li>
                <li class="list-group-item"><strong>E-mail: </strong> {{ $company->email }}</li>

                <li class="list-group-item"><strong>Cadastrado em
                        : </strong> {{ \Carbon\Carbon::parse($company->createdAt)->format('d/m/Y H:i:s') }}</li>
                <li class="list-group-item"><strong>&Uacute;ltima atualiza&ccedil;&atilde;o
                        : </strong> {{ \Carbon\Carbon::parse($company->updatedAt)->format('d/m/Y H:i:s') }}</li>
                <li class="list-group-item">

                    <a href="{{ route('user-company.identify', $company->id) }}"
                       class="btn btn-primary btn-md" title="Usu&aacute;rios"><span
                                class="glyphicon glyphicon-user"></span></a>

                    <a href="{{ route('provider.identify', $company->id) }}"
                       class="btn btn-warning btn-md" title="Prestadores de servi&ccedil;os"><span
                                class="glyphicon glyphicon-briefcase"></span></a>
                    <td>
                        <a href="{{ route('report.identify', $company->id) }}"
                           class="btn btn-primary btn-md" title="Relat&oacute;rios"><span
                                    class="glyphicon glyphicon-signal"></span></a>
                    </td>

                    @can('onlyAdmin')
                    <a href="{{ route('company.edit', $company->id) }}"
                       class="btn btn-success btn-md" title="Editar"><span
                                class="glyphicon glyphicon-pencil"></span></a>

                    <a href="#"
                       class="btn btn-danger btn-md modal-delete" title="Excluir"
                       data-toggle="modal"
                       data-target="#delete"
                       rel="{{ route('company.destroy', $company->id) }}"><span
                                class="glyphicon glyphicon-trash"></span></a>

                    @endcan

                </li>
            </ul>
        </div>
    </div>
</div>

<!-- /page content -->
@endsection
