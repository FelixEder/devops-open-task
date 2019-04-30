@extends('layouts/master')

@section('content')

@javascript(compact('pusherKey', 'clientConnectionPath', 'environment', 'openWeatherMapKey'))
<div id="dashboard">
    <dashboard class="font-sans">
        <main-repo position="a1:a12"></main-repo>
        <calendar position="a13:a24"></calendar>
        <time-weather position="e1:e6" date-format="ddd DD/MM" time-zone="Europe/Stockholm" weather-city="Stockholm"></time-weather>
        <internet-connection position="e1:e6"></internet-connection>
        <statistics position="d1:d10"></statistics>
    </dashboard>
</div>

@endsection