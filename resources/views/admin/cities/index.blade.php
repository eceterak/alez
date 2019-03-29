@extends('admin.layouts.master')

@section('content')
    <div class="card">
        <header>
            <h3>
                Miasta
                <small class="text-grey-darker">[{{ $cities->count() }}]</small>
            </h3>
            <a href="/admin/miasta/dodaj" class="btn">Dodaj</a>
        </header>
        <div>
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-left">Nazwa</th>
                        <th class="text-left">Pokoje</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cities as $city)
                        <tr>
                            <td><a href="{{ route('admin.cities.edit', $city->path()) }}">{{ $city->name }}</a></td>
                            <td class="fit">{{ $city->rooms->count() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection