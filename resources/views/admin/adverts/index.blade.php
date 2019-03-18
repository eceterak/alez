@extends('admin.layouts.master')

@section('content')
    <div class="card">
        <header>
            <h3>
                Pokoje
                <small class="text-grey-darker">[{{ $adverts->count() }}]</small>
            </h3>
            <a href="/admin/miasta/dodaj" class="btn">Dodaj</a>
        </header>
        <div>
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-left">Nazwa</th>
                        <th class="text-left">Ogłoszenia</th>
                        <th class="text-left">Promowane</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($adverts as $advert)
                        <tr>
                            <td><a href="{{ $advert->path(true) }}">{{ $advert->title }}</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection