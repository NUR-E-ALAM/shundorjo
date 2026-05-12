@extends('frontend.layouts.app')
@section('title')
    About Us
@stop
@section('content')

    <section class="gry-bg py-4">
        <style>
            img {
                max-width: -webkit-fill-available;
    }
        </style>
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="p-4 bg-white">

                        @php
                            echo \App\Models\Policy::where('name', 'about')->first()->content;
                        @endphp

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
