@extends('layouts.panel')

@section('title', 'Formul&aacute;rio de empresa')

@section('content')
    <!-- page content -->
    <div class="right_col" role="main">

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Empresa
                            <span class="text-primary">formul&aacute;rio de cadastro</span>
                        </h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br/>
                        <form id="company-form" data-parsley-validate class="form-horizontal form-label-left">
                            <table style="width: 100%;" border="0">
                                <tr>
                                    <td>
                                        <div class="control-group">
                                            <label class="control-label" for="name">Nome *</label>
                                            <div class="controls">
                                                <input id="name" name="name" type="text" placeholder="" class="input" required="">
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="control-group">
                                            <label class="control-label" for="fantasyName">Nome fantasia </label>
                                            <div class="controls">
                                                <input id="fantasyName" name="fantasyName" type="text" placeholder="" class="input">
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="control-group">
                                            <label class="control-label" for="openingDate">Data de abertura *</label>
                                            <div class="controls">
                                                <input id="openingDate" name="openingDate" type="text" placeholder="" class="input" required="">
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="control-group">
                                            <label class="control-label" for="address">Endereço *</label>
                                            <div class="controls">
                                                <input id="address" name="address" type="text" placeholder="" class="input" required="">
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="control-group">
                                            <label class="control-label" for="phone">Telefone *</label>
                                            <div class="controls">
                                                <input id="phone" name="phone" type="text" placeholder="" class="input" required="">
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="control-group">
                                            <label class="control-label" for="cnpj">CNPJ *</label>
                                            <div class="controls">
                                                <input id="cnpj" name="cnpj" type="text" placeholder="" class="input" required="">
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="control-group">
                                            <label class="control-label" for="initialCapital">Capital Inicial *</label>
                                            <div class="controls">
                                                <input id="initialCapital" name="initialCapital" type="text" placeholder="" class="input" required="">
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="control-group">
                                            <label class="control-label" for="meEpp">ME/EPP *</label>
                                            <div class="controls">
                                                <input id="meEpp" name="meEpp" type="text" placeholder="" class="input" required="">
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="control-group">
                                            <label class="control-label" for="municipalRegistration">Insc. Municipal *</label>
                                            <div class="controls">
                                                <input id="municipalRegistration" name="municipalRegistration" type="text" placeholder="" class="input" required="">
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="control-group">
                                            <label class="control-label" for="stateRegistration">Insc. Estadual *</label>
                                            <div class="controls">
                                                <input id="stateRegistration" name="stateRegistration" type="text" placeholder="" class="input" required="">
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="control-group">
                                            <label class="control-label" for="cnaef11">C.N.A.E.F.1.1 *</label>
                                            <div class="controls">
                                                <input id="cnaef11" name="cnaef11" type="text" placeholder="" class="input" required="">
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="control-group">
                                            <label class="control-label" for="cnae22">C.N.A.E.2.2 *</label>
                                            <div class="controls">
                                                <input id="cnae22" name="cnae22" type="text" placeholder="" class="input" required="">
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="control-group">
                                            <label class="control-label" for="natureEstablishment">Natureza do estabelecimento *</label>
                                            <div class="controls">
                                                <input id="natureEstablishment" name="natureEstablishment" type="text" placeholder="" class="input" required="">
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="control-group">
                                            <label class="control-label" for="codeCei">Código C.E.I *</label>
                                            <div class="controls">
                                                <input id="codeCei" name="codeCei" type="text" placeholder="" class="input" required="">
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="control-group">
                                            <label class="control-label" for="cnae">CNAE *</label>
                                            <div class="controls">
                                                <input id="cnae" name="cnae" type="text" placeholder="" class="input" required="">
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="control-group">
                                            <label class="control-label" for="simpleOperationCode">Code de Op. Simples (Sefip) *</label>
                                            <div class="controls">
                                                <input id="simpleOperationCode" name="simpleOperationCode" type="text" placeholder="" class="input" required="">
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="control-group">
                                            <label class="control-label" for="paymentCodeFgts">Código de pagamento FGTS *</label>
                                            <div class="controls">
                                                <input id="paymentCodeFgts" name="paymentCodeFgts" type="text" placeholder="" class="input" required="">
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="control-group">
                                            <label class="control-label" for="inssEmployerRate">Alíquota INSS Empregador(%) *</label>
                                            <div class="controls">
                                                <input id="inssEmployerRate" name="inssEmployerRate" type="text" placeholder="" class="input" required="">
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="control-group">
                                            <label class="control-label" for="fpas">F.P.A.S *</label>
                                            <div class="controls">
                                                <input id="fpas" name="fpas" type="text" placeholder="" class="input" required="">
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="control-group">
                                            <label class="control-label" for="thirdPartyCode">Código Terceiros *</label>
                                            <div class="controls">
                                                <input id="thirdPartyCode" name="thirdPartyCode" type="text" placeholder="" class="input" required="">
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="control-group">
                                            <label class="control-label" for="cityCodeRais">Código Município RAIS *</label>
                                            <div class="controls">
                                                <input id="cityCodeRais" name="cityCodeRais" type="text" placeholder="" class="input" required="">
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="control-group">
                                            <label class="control-label" for="thirdParty">% Terceiros *</label>
                                            <div class="controls">
                                                <input id="thirdParty" name="thirdParty" type="text" placeholder="" class="input" required="">
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="control-group">
                                            <label class="control-label" for="rat">% R.A.T *</label>
                                            <div class="controls">
                                                <input id="rat" name="rat" type="text" placeholder="" class="input" required="">
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="control-group">
                                            <label class="control-label" for="fap">% F.A.P *</label>
                                            <div class="controls">
                                                <input id="fap" name="fap" type="text" placeholder="" class="input" required="">
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="control-group">
                                            <label class="control-label" for="salaryEducation">Sálario Educação (%) *</label>
                                            <div class="controls">
                                                <input id="salaryEducation" name="salaryEducation" type="text" placeholder="" class="input" required="">
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="control-group">
                                            <label class="control-label" for="sesi">SESI (%) *</label>
                                            <div class="controls">
                                                <input id="sesi" name="sesi" type="text" placeholder="" class="input" required="">
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="control-group">
                                            <label class="control-label" for="deduction">Dedução (%) *</label>
                                            <div class="controls">
                                                <input id="deduction" name="deduction" type="text" placeholder="" class="input" required="">
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="control-group">
                                            <label class="control-label" for="specificEvents">Eventos Específicos *</label>
                                            <div class="controls">
                                                <input id="specificEvents" name="specificEvents" type="text" placeholder="" class="input" required="">
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="control-group">
                                            <label class="control-label" for="lastCct">Última CCT *</label>
                                            <div class="controls">
                                                <input id="lastCct" name="lastCct" type="text" placeholder="" class="input" required="">
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="control-group">
                                            <label class="control-label" for="totalEmployeesAllocated">Total de funcionários alocados *</label>
                                            <div class="controls">
                                                <input id="totalEmployeesAllocated" name="totalEmployeesAllocated" type="text" placeholder="" class="input" required="">
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="height: 50px;">
                                        <div class="control-group">
                                            <div class="controls">
                                                <label class="radio-inline" for="customerProvider-0">
                                                    <input type="radio" name="customerProvider" id="customerProvider-0" value="json" checked="checked"> Cliente
                                                </label>
                                                <label class="radio-inline" for="customerProvider-1">
                                                    <input type="radio" name="customerProvider" id="customerProvider-1" value="xml"> Prestador
                                                </label>
                                            </div>
                                        </div>
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>

                                <tr>
                                    <td style="height: 50px;">
                                        <div class="control-group">
                                            <div class="controls">
                                                <button type="submit" class="btn btn-success">Salvar</button>
                                                <button class="btn btn-warning" type="reset">Limpar</button>
                                                <a href="{{ url('company') }}" class="btn btn-danger">Cancelar</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>

                            </table>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- /page content -->
@endsection