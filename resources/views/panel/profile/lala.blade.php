@extends('layouts.panel')

@section('title', 'Gest&atilde;o de usu&aacute;rio')

@section('content')
    <!-- page content -->
    <style>
        .material-switch > input[type="checkbox"] {
            display: none;
        }

        .material-switch > label {
            cursor: pointer;
            height: 0px;
            position: relative;
            width: 40px;
        }

        .material-switch > label::before {
            background: rgb(0, 0, 0);
            box-shadow: inset 0px 0px 10px rgba(0, 0, 0, 0.5);
            border-radius: 8px;
            content: '';
            height: 16px;
            margin-top: -8px;
            position:absolute;
            opacity: 0.3;
            transition: all 0.4s ease-in-out;
            width: 40px;
        }
        .material-switch > label::after {
            background: rgb(255, 255, 255);
            border-radius: 16px;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
            content: '';
            height: 24px;
            left: -4px;
            margin-top: -8px;
            position: absolute;
            top: -4px;
            transition: all 0.3s ease-in-out;
            width: 24px;
        }
        .material-switch > input[type="checkbox"]:checked + label::before {
            background: inherit;
            opacity: 0.5;
        }
        .material-switch > input[type="checkbox"]:checked + label::after {
            background: inherit;
            left: 20px;
        }
    </style>

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
