@extends('layouts.master')

@section('breadcrumbs')
    @include('users._menu')
@endsection

@section('content')
    @if($conversations->count())
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    @foreach($conversations as $conversation)
                        <div class="col-lg-2 text-center">
                            {{-- <img src="{{ $conversation->interlocutor->avatar_path }}" alt="" class="card-img-top img-fluid rounded-circle" style="width: 2.5rem; height: 2.5rem;"> --}}
                            <p class="mb-3 mb-lg-0 font-weight-bold">{!! $conversation->interlocutor->path !!}</p>
                        </div>
                        <div class="col-lg-8 pr-lg-0">
                            <div class="d-flex justify-content-between">
                                <h5 @if($conversation->advert->archived) style="text-decoration: line-through;" @endif>
                                    <a href="{{ route('adverts.show', [$conversation->advert->city->slug, $conversation->advert->slug]) }}">{{ $conversation->advert->title }}<i class="fas fa-link fa-xs ml-1"></i></a>
                                </h5>
                            </div>
                            <p class="card-text">
                                @if($conversation->hasNewMessagesFor($profile))
                                    <strong><a href="{{ route('conversations.show', $conversation->id) }}">{{ str_limit($conversation->messages()->first()->body, 100) }}</a></strong>
                                @else
                                    <a href="{{ route('conversations.show', $conversation->id) }}">{{ str_limit($conversation->messages()->first()->body, 100) }}</a>
                                @endif
                            </p>
                        </div>
                        <div class="col-lg-2 text-right">
                            <p class="mb-0 text-muted">
                                @if($conversation->updated_at->diffInDays() < 1)
                                    {{ $conversation->updated_at->format('H:i') }}
                                @else
                                    @if($conversation->updated_at->diffInYears() < 1)
                                        {{ $conversation->updated_at->format('j F') }}
                                    @else
                                        {{ $conversation->updated_at->format('j F Y') }}
                                    @endif
                                @endif
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-body text-center">
                <p class="card-text">Nie masz żadnych odebranych wiadomości</p>
            </div>
        </div>
    @endif
@endsection