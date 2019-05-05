@extends('admin.layouts.master')

@section('content')

<div class="card w-1/2">
    <header>
        <h3>Aktywności</h3>
    </header>
    @if($activities->count())
        <table class="table">
            <tbody>
                @foreach($activities as $activity)
                    <tr>
                        <td>@include("admin.dashboard.activities.{$activity->description}")</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="card-content">
            <p>Brak aktywności</p>
        </div>
    @endif      
</div>

@endsection