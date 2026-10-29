@extends('template.template')
@section('content')

<ul class="nav nav-tabs custom-tabs" id="gacTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="casos-tab" data-bs-toggle="tab" data-bs-target="#dvCasos" type="button" role="tab">Ingreso de Casos</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="cuenta-tab" data-bs-toggle="tab" data-bs-target="#dvCuenta" type="button" role="tab">Información de Cuenta</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="cliente-tab" data-bs-toggle="tab" data-bs-target="#dvCliente" type="button" role="tab">Información de Cliente</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="abonado-tab" data-bs-toggle="tab" data-bs-target="#dvAbonado" type="button" role="tab">Información de Abonado</button>
    </li>
</ul>

<div class="tab-content" id="gacTabsContent">
    
    <div class="tab-pane fade show active" id="dvCasos" role="tabpanel">
        @include('gac.case_intake')
    </div>
    
    <div class="tab-pane fade" id="dvCuenta" role="tabpanel">
        @include('gac.account_information')
    </div>

    <div class="tab-pane fade" id="dvCliente" role="tabpanel">
        @include('gac.customer_information')
    </div>

    <div class="tab-pane fade" id="dvAbonado" role="tabpanel">
        @include('gac.subscriber_information')
    </div>

</div>

@endsection

