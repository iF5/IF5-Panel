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
                    <li class="list-group-item"><strong>Ramo de Atividade : </strong> {{ $company->activityBranch }}
                    </li>


                    <li class="list-group-item"><strong>CNPJ : </strong> {{ $company->cnpj }}</li>
                    <li class="list-group-item"><strong>Inscrição Estadual : </strong> {{ $company->stateInscription }}
                    </li>
                    <li class="list-group-item"><strong>Inscrição Municipal
                            : </strong> {{ $company->municipalInscription }}
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

                    <li class="list-group-item"><strong>Nome responsável : </strong> {{ $company->responsibleName }}
                    </li>
                    <li class="list-group-item"><strong>Celular: </strong> {{ $company->cellPhone }}</li>
                    <li class="list-group-item"><strong>E-mail: </strong> {{ $company->email }}</li>

                    <!-- Documents -->
                    <li class="list-group-item"><strong>Documentos: </strong><br/>
                        @foreach($documents as $document)
                            @if(in_array($document->id, $selectedDocuments))
                                &nbsp;&nbsp;-&nbsp;{{$document->name}}<br />
                            @endif
                        @endforeach
                    </li>
                    <!-- End Documents -->

                    <li class="list-group-item"><strong>Cadastrado em
                            : </strong> {{ Period::format($company->createdAt, 'd/m/Y H:i') }}</li>
                    <li class="list-group-item"><strong>&Uacute;ltima atualiza&ccedil;&atilde;o
                            : </strong> {{ Period::format($company->updatedAt, 'd/m/Y H:i') }}</li>
                    <li class="list-group-item">
                        <a href="{{ route('company.edit', $company->id) }}"
                           class="btn btn-success btn-md" title="Editar"><span
                                    class="glyphicon glyphicon-pencil"></span></a>

                        <a href="#"
                           class="btn btn-danger btn-md modal-delete" title="Excluir"
                           data-toggle="modal"
                           data-target="#delete"
                           rel="{{ route('company.destroy', $company->id) }}"><span
                                    class="glyphicon glyphicon-trash"></span></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- /page content -->
@endsection
