@extends('layouts/master')

@section('content')

@javascript(compact('pusherKey', 'clientConnectionPath', 'environment', 'openWeatherMapKey'))
<div id="dashboard">
    <dashboard class="font-sans">
        <main-repo position="a7:a24"></main-repo>
        <time-weather position="a1:a6" date-format="ddd DD/MM" time-zone="Europe/Stockholm" weather-city="Stockholm"></time-weather>
        <internet-connection position="e1:e6"></internet-connection>
    </dashboard>
</div>