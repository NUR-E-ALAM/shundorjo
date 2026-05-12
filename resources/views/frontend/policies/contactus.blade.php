@extends('frontend.layouts.app')

@section('title')
    Contact Us
@stop

@section('content')

    <section class="gry-bg py-4">
        <div class="container">
            <form action="{{ route('contactus.store') }}" method="POST">
                @csrf
                <div class="form-box bg-white mt-4">
                    <div class="form-box-title px-3 py-2">
                        {{__('Contact Us')}}
                    </div>
                    <div class="form-box-content p-3">
                        <div class="row">
                            <div class="col-md-2">
                                <label>{{__('Your Name')}}</label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control mb-3" placeholder="{{__('Your Name')}}" name="name"  @if (!empty(Auth::user()->name))
                                value="{{ Auth::user()->name }}"
                                @else
                                value=""
                                @endif>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label>{{__('Your Email')}}</label>
                            </div>
                            <div class="col-md-10">
                                <input type="email" class="form-control mb-3" placeholder="{{__('Your Email')}}" name="email" @if (!empty(Auth::user()->email))
                                value="{{ Auth::user()->email }}"
                                @else
                                value=""
                                @endif>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <label>{{__('Message')}}</label>
                            </div>
                            <div class="col-md-10">
                                <textarea name="message" id="message"  class="form-control mb-3" placeholder="{{__('Your Message')}}" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                        
                    </div>
                </div>
                

                <div class="text-right mt-4">
                    <button type="submit" class="btn btn-styled btn-base-1">{{__('Send')}}</button>
                </div>
            </form>
        </div>
    </section>

@endsection
