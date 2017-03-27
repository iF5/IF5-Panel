@extends('layouts.panel')

@section('title', 'Gest&atilde;o de usu&aacute;rio')

@section('content')
    <!-- page content -->

    <div class="right_col" role="main">
        <div class="row">
            <div class="x_panel">

                <!-- List group -->
                <ul class="list-group">
                    <li class="list-group-item">
                        Bootstrap Switch Default
                        <div class="material-switch pull-right">
                            <input id="someSwitchOptionDefault" name="someSwitchOption001" type="checkbox"/>
                            <label for="someSwitchOptionDefault" class="label-default"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        Bootstrap Switch Primary
                        <div class="material-switch pull-right">
                            <input id="someSwitchOptionPrimary" name="someSwitchOption001" type="checkbox"/>
                            <label for="someSwitchOptionPrimary" class="label-primary"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        Bootstrap Switch Success
                        <div class="material-switch pull-right">
                            <input id="someSwitchOptionSuccess" name="someSwitchOption001" type="checkbox"/>
                            <label for="someSwitchOptionSuccess" class="label-success"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        Bootstrap Switch Info
                        <div class="material-switch pull-right">
                            <input id="someSwitchOptionInfo" name="someSwitchOption001" type="checkbox"/>
                            <label for="someSwitchOptionInfo" class="label-info"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        Bootstrap Switch Warning
                        <div class="material-switch pull-right">
                            <input id="someSwitchOptionWarning" name="someSwitchOption001" type="checkbox"/>
                            <label for="someSwitchOptionWarning" class="label-warning"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        Bootstrap Switch Danger
                        <div class="material-switch pull-right">
                            <input id="someSwitchOptionDanger" name="someSwitchOption001" type="checkbox"/>
                            <label for="someSwitchOptionDanger" class="label-danger"></label>
                        </div>
                    </li>
                </ul>


            </div>
        </div>
    </div>

    <!-- /page content -->
@endsection
