@extends('frontend.layouts.app')
@section('title')
    About Us
@stop
@section('content')

    <section class="gry-bg py-4">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="p-4 bg-white">

                        <div class="col-md-12">
                            <div class="card">
                              <div class="card-header">
                                <h4>Special Offers</h4>
                              </div>
                              <div class="card-body" id="offersContainer">
                                <div class="card">                    
                                    <div class="card-body">


                                            

                                            @foreach (App\Models\SpecialOffer::where('status', '=', '1')->get() as $offer)
                                                <div class="list-group d-flex flex-row border-bottom mb-3 pb-3">
                                                    <div class="me-3">
                                                        <img loading="lazy" src="https://cdn2.arogga.com/assets/img/speacial_offer.png" width="50" height="60" alt="">
                                                    </div>
                                                    <div>
                                                        <h5 class="card-title">{{$offer->title}} ৳{{$offer->tamount}}</h5>
                                                        <p class="card-text">For purchasing {{$offer->upto}} ৳{{$offer->uamount}}</p>
                                                    </div>
                                                </div>
                                            @endforeach


                                            {{-- <div class="list-group d-flex flex-row border-bottom mb-3 pb-3">
                                                <div class="me-3">
                                                    <img loading="lazy" src="https://cdn2.arogga.com/assets/img/speacial_offer.png" width="50" height="60" alt="">
                                                </div>
                                                <div>
                                                    <h5 class="card-title">Cashback   ৳80</h5>
                                                    <p class="card-text">For purchasing above ৳4000+</p>
                                                </div>
                                            </div>



                                            <div class="list-group d-flex flex-row border-bottom mb-3 pb-3">
                                                <div class="me-3">
                                                    <img loading="lazy" src="https://cdn2.arogga.com/assets/img/speacial_offer.png" width="50" height="60" alt="">
                                                </div>
                                                <div>
                                                    <h5 class="card-title">Cashback   ৳60</h5>
                                                    <p class="card-text">For purchasing above ৳3000+</p>
                                                </div>
                                            </div>


                                            <div class="list-group d-flex flex-row border-bottom mb-3 pb-3">
                                                <div class="me-3">
                                                    <img loading="lazy" src="https://cdn2.arogga.com/assets/img/speacial_offer.png" width="50" height="60" alt="">
                                                </div>
                                                <div>
                                                    <h5 class="card-title">Cashback   ৳40</h5>
                                                    <p class="card-text">For purchasing above ৳2000+</p>
                                                </div>
                                            </div>


                                            <div class="list-group d-flex flex-row border-bottom mb-3 pb-3">
                                                <div class="me-3">
                                                    <img loading="lazy" src="https://cdn2.arogga.com/assets/img/speacial_offer.png" width="50" height="60" alt="">
                                                </div>
                                                <div>
                                                    <h5 class="card-title">Cashback   ৳20</h5>
                                                    <p class="card-text">For purchasing above ৳1000+</p>
                                                </div>
                                            </div> --}}


                                    </div>
                                </div>
                            </div>
                            </div>
                          </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
