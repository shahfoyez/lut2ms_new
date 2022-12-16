<?php
    $formAction = '/trip/history/filter';
    $refreshAction = '/trip/history';
?>
@include('components.filter.dateFilter')
@include('components.filter.filterRefresh')


@php
$formAction = '/fuel/vehicleFuels/'.$vehicle->id.'/filter';
$refreshAction = '/fuel/vehicleFuels/'.$vehicle->id;
@endphp
@include('components.filter.dateFilter')
@include('components.filter.filterRefresh')



<?php
$formAction = '/requisition/vehicles/filter';
$refreshAction = '/requisition/vehicles';
?>
@include('components.filter.statusFilter')
@include('components.filter.filterRefresh')
