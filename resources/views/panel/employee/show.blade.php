@extends('layouts.panel')

@section('title', 'Gest&atilde;o de funcion&aacute;rios')

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
                <li class="list-group-item"><strong>Nome : </strong> {{ $employee->name }}</li>
                <li class="list-group-item"><strong>CPF : </strong> {{ $employee->cpf }}</li>


                <li class="list-group-item"><strong>RG : </strong> {{ $employee->rg }}</li>
                <li class="list-group-item"><strong>CTPS número : </strong> {{ $employee->ctps }}</li>
                <li class="list-group-item"><strong>Data de nascimento : </strong> {{ $employee->birthDate }}</li>
                <li class="list-group-item"><strong>Endereço : </strong> {{ $employee->street }}</li>
                <li class="list-group-item"><strong>Bairro : </strong> {{ $employee->district }}</li>
                <li class="list-group-item"><strong>Cidade : </strong> {{ $employee->city }}</li>
                <li class="list-group-item"><strong>Estado : </strong> {{ $employee->state }}</li>
                <li class="list-group-item"><strong>Função : </strong> {{ $employee->jobRole }}</li>
                <li class="list-group-item"><strong>Piso salarial
                        : </strong> R$ {{ number_format($employee->salaryCap, 2, ',', '.') }}</li>
                <li class="list-group-item"><strong>Data contratação : </strong> {{ $employee->hiringDate }}</li>
                <li class="list-group-item"><strong>Data da rescisão : </strong> {{ $employee->endingDate }}</li>
                <li class="list-group-item"><strong>Número do PIS : </strong> {{ $employee->pis }}</li>
                <li class="list-group-item"><strong>Jornada de trabalho : </strong> {{ $employee->workingHours }}</li>
                <li class="list-group-item"><strong>Regime de trabalho : </strong> {{ $employee->workRegime }}</li>
                <li class="list-group-item"><strong>Tem filhos menores
                        : </strong> {{ ($employee->hasChildren)? 'Sim' : 'N&atilde;o' }}</li>
                <li class="list-group-item"><strong>Empresas alocadas : </strong>
                    @foreach($companies as $company)
                        @if($company->companyId) <br />&nbsp;&nbsp;{{ $company->name }} @endif
                    @endforeach
                </li>


                <li class="list-group-item">
                    @if(!$employee->status && \Auth::user()->role === 'admin')
                        <a href="#"
                           class="btn btn-success btn-md modal-update" title="Aprovar"
                           data-toggle="modal"
                           data-target="#update"
                           rel="{{ route('pendency.approve', ['companyId' => 0, 'id' => $employee->id, 'source' => 'employee']) }}"
                           rev="Tem certeza que deseja aprovar este registro?"><span
                                    class="glyphicon glyphicon-thumbs-up"></span></a>
                    @else
                        <a href="{{ route('employee.edit', $employee->id) }}"
                           class="btn btn-success btn-md"><span
                                    class="glyphicon glyphicon-pencil"></span></a>

                        <a href="#"
                           class="btn btn-danger btn-md modal-delete" data-title="Excluir"
                           data-toggle="modal"
                           data-target="#delete"
                           rel="{{ route('employee.destroy', $employee->id) }}"><span
                                    class="glyphicon glyphicon-trash"></span></a>
                    @endif
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- /page content -->
@endsection
