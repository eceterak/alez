@extends('layouts.master')

@section('breadcrumbs')
    @include('users._menu')
@endsection

@section('content')
    <h5>Obserwowane miasta</h5>
    @if($subscriptions->count())
        <ul class="list-group">
            @foreach($subscriptions as $subscription)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <p class="mb-0">{{ $subscription->city->name }}</p>
                    <form action="{{ route('city.unsubscribe', $subscription->city->slug) }}" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger d-inline">Usuń</button>
                    </form>
                </li>
            @endforeach
        </ul>
    @else
        <p>Nie obserwujesz żadnych miast</p>
    @endif

    <h5 class="mt-4">Powiadomienia</h5>
    @if($notifications->count())
        <ul class="list-group">
            @foreach($notifications as $notification)
                <li class="list-group-item">
                    @if($notification->unread())
                        <p class="mb-0"><i class="fas fa-bell fa-xs mr-2"></i><strong>{!! $notification->data['message'] !!}</strong></p>
                    @else
                        <p class="mb-0">
                            <i class="far fa-bell fa-xs mr-2"></i>
                            <span>{!! $notification->data['message'] !!}</span>
                            <span class="float-right">{{ $notification->created_at->diffForHumans() }}</span>
                        </p>
                    @endif
                </li>
            @endforeach
        </ul>
    @else
        <p class="mb-0">Nie masz żadnych powiadomień</p>
    @endif
@endsection