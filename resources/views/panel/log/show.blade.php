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
                <li class="list-group-item"><strong>A&ccedil;&atilde;o : </strong> {{ $verbs[$log->method] }}</li>
                <li class="list-group-item"><strong>Tit&uacute;lo : </strong> {{ $log->title }}</li>
                <li class="list-group-item"><strong>Usu&aacute;rio : </strong> {{ $log->userName }}</li>
                <li class="list-group-item"><strong>E-mail : </strong> {{ $log->email }}</li>
                <li class="list-group-item"><strong>Gerado em
                        : </strong> {{ \Carbon\Carbon::parse($log->createdAt)->format('d/m/Y H:i:s') }}</li>

                <li class="list-group-item">
                    <code>
                        @foreach ($log->data as $key => $value)
                            {{ $key }} = {{ $value }}<br />
                        @endforeach
                    </code>
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- /page content -->
@endsection
