@extends('frontend.layouts.app')

@section('title')
    Upload-Prescription Apon Health
@stop
@section('content')

<style>
.imageThumb {
    max-height: 75px;
    border: 2px solid;
    padding: 1px;
    cursor: pointer;
    width: 110px;
    height: 50px;
    object-fit: contain;
}
.pip {
  display: inline-block;
  margin: 10px 10px 0 0;
}
.deleteImg {
  display: block;
  background: #444;
  border: 1px solid black;
  color: white;
  text-align: center;
  cursor: pointer;
}
.deleteImg:hover {
  background: white;
  color: black;
}
@media (max-width: 480px){
    .pip{width: 100%}
    .imageThumb{width: 100%;}
}
</style>
<div class="my-4">
    <div class="container">
        <div class="row">
            <div class="col-md-12 my-3 why_prescription">
                <p style="color: #10837d;" class="h5">কেন প্রেসক্রিপশনের ছবি আপলোড করবেন?</p>
                <ul>
                    <li>প্রেসক্রিপশন হারানোর ভয় থেকে আপনি মুক্ত, আজীবনের জন্য আপন হেল্থে আপনি খুজে পাবেন আপনার ডিজিটাল প্রেসক্রিপশন।</li>
                    <li>ডাক্তারের হাতের লেখা বুঝা না গেলেও কোন সমস্যা নেই, আমাদের 'A' গ্রেড ফার্মাসিস্ট প্রেস্ক্রিপশন দেখে ঔষধ অর্ডারে আপনাকে সহযোগিতা করবে।</li>
                    <li>আপনার প্রেসক্রিপশন কখনো তৃতীয় কোন পক্ষের সাথে শেয়ার করা হবে না।</li>
                    <li>বাংলাদেশ সরকারের নিয়ম অনুসারে, কিছু মেডিসিন অর্ডার করার জন্য প্রেসক্রিপশন থাকা বাধ্যতামুলক।</li>
                </ul>
            </div>
            <div class="col-md-6 my-3">
                <div class="card">
                    
                    <div class="card-body py-5">
                        <form action="{{route('upload-prescription-done')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <p class="h4 m-0">Have any prescription? Upload here</p>
                            <small>(Maximum 5 pages)</small>
                            <div class="custom-file mt-3 field">
                                
                                    
                                
                                <input type="number" class="form-control" id="mobile" name="mobile" placeholder="Mobile" @auth value="{{Auth::user()->phone}}" readonly @endauth required>
                            </div>
                            <div class="custom-file mt-3 field">
                                <input type="file" class="form-control" id="uploadPrescriptionField"  multiple accept="image/*" max="5" capture="camera" name="image[]" required>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-info mt-3">Upload Prescription</button>
                            </div>
                            <div class="d-flex align-items-start mt-3">
                                <img loading="lazy" width="10" src="https://cdn2.arogga.com/assets/img/discountTag.png" alt="arogga.com">
                                <small style="font-size:11px;margin: -4px 0 0 5px;">You attached prescription will be secure and private. Only our pharmacist will review it.</small>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6 my-3">
                <div class="card">
                    <div class="card-header">
                        <h5>Valid Prescription Guide</h5>
                    </div>
                    <div class="card-body d-flex">
                        <div class="m-2">
                            <img src="https://cdn2.arogga.com/assets/img/prescriptionImage.jpg"  class="img-fluid" alt="arogga prescription guide">
                        </div>
                        <div class="m-2">
                            <ul>
                                <li class="mb-3">Include details of doctor and patient+clinic visit details.</li>
                                <li>Medicines will be dispensed as per prescription.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
</div>
@endsection
@section('script')

@endsection
