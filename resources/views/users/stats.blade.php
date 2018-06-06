@extends('master')

@section('content')


<div class="container">
    <h1>Your statistics</h1>
</div>

            <h3>Department: {{$department->name}}</h3>
            <h3>Total Number of Prints: {{$deparmentPrints}}</h3>


<div id="chart-div">

    {!! $lavaDep->render('PieChart', 'Prints', 'chart-div') !!}

</div>

<div id="chart-div">

    <h4> Total prints of today is {{ $printCountTodayDep }}.<h4>

    <h4> Daily average prints of {{ $currentMonthName }} of {{$currentYear}} is {{$printsAverageMonthDep}}.<h4>

</div>



@endsection('content')