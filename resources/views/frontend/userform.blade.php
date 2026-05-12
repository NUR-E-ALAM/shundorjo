@extends('frontend.layouts.app')
@section('title')
    User Form
@stop
@section('content')

<section style="width: 80%; margin: 0 auto; margin-top: 55px;">
    <h6>
আপনি বা আপনার পরিবারের কেউ কি নিয়মিত ওষুধ খান? মাঝে মাঝে কি ভুলে যান ওষুধ কিনার কথা ? 
দায়িত্বটা দিতে পারেন আপন হেলথ এর হাতে।
 আপনার প্রয়োজনীয় যে কোন ওষুধ শেষ হওয়ার আগেই আমরা, আপন হেলথ পৌঁছে দিবো আপনার বাসায়। 
এই সেবাটি পেতে ওয়েবসাইটে, আপনার নাম, ঠিকানা, ফোন নম্বর দিয়ে ফর্মটি পুরন করে পাঠিয়ে দিন আমাদের কাছে। 
যারা বিদেশ থাকেন তারাও নিতে পারেন এই সেবা। আমরা আছি পাশে- আপনার আপনজনের ওষুধ ঠিক সময়ে পৌঁছে দিতে।


    <br/> <br>
     আপন হেলথ- আপনার স্বাস্থ্য সহকারী। এখানে ফ্রি একাউন্ট করে হেলথ প্রোফাইল তৈরি করতে পারবেন। রাখতে পারবেন আপনার দরকারি সব প্রেসক্রিপশন ও ডায়াগনস্টিক রিপোর্ট, যা প্রয়োজন হলেই ডাক্তারকে শেয়ার বা প্রিন্ট করে নিতে পারবেন। আপনহেলথ- সব সময় স্বাস্থ্য বিষয়ক বিভিন্ন আর্টিকেল প্রকাশ করবে।
    </h6>
</section>

<section class="order mb-5">
    <div class="container-fluid">
      <div class="row ">
        <div class="col-lg-1"></div>
        <div class="col-lg-7">
          <div class="contact-box-layout1 shadow-sm p-4">
            <!--<h4 class="title title-bar-primary4 position-relative pb-3 mt-5 pb-3 text-capitalize">please leave us a message and we will get back to you shortly</h4>-->

            <div class="pmessage"></div>

            <form class="contact-form-box mt-4"  action="{{route('regularmedication.store')}}" method="post">
              @csrf
              <div class="row">
                <div class="col-md-12 form-group">
                  <input type="text" placeholder="Name  নাম  *" class="form-control" id="name" name="name" required>
                </div>
                <div class="col-md-6 form-group">
                  <input type="email" placeholder="E-mail ইমেইল " class="form-control" id="email" name="email" required>
                </div>
                <div class="col-md-6 form-group">
                  <input type="text" placeholder="Phone ফোন নাম্বার  *" class="form-control" id="phone" name="phone" required>
                </div>
                <div class="col-12 form-group">
                  <textarea placeholder="Address এড্রেস *" class="textarea form-control" name="address" id="address" rows="2" cols="20" data-error="Message field is required" required></textarea>
                </div>
                <div class="col-12 form-group">
                  <textarea placeholder="Write anything you would like to know. কিছু জানার থাকলে লিখতে পারেন " class="textarea form-control" name="message" id="message"
                    rows="7" cols="20" data-error="Message field is required" required></textarea>
                </div>
                <input type="hidden" name="contactform" value="1">
                <div class="col-12 form-group margin-b-none">
                  <button type="submit" class="btn btn-info mt-3">Submit</button>
                </div>
              </div>
            </form>

          </div>
        </div>
        <div class="col-lg-4 pl-4">
          <div class="contact-box-layout1 p-4">
            <img src="{{asset('images/right.png')}}" height="80%" width="300" alt="">
          </div>
        </div>

      </div>
    </div>

</section>
<section style="width: 80%; margin: 0 auto; margin-top: 0px;">
<b>বাসায় বসে আপনার নিয়মিত ঔষধ রিসিভ করার পাশাপাশি আপনি ওয়েবসাইট থেকেও ঔষধ & দরকারি প্রোডাক্ট অর্ডার করতে পারবেন </b><br><br>
<h5><u>আরো যেসব সেবা আপন হেলথ প্লাটফর্ম থেকে পাবেন। </u></h5>
<p>আপন হেলথ- আপনার স্বাস্থ্য সহকারী। এখানে ফ্রি একাউন্ট করে হেলথ প্রোফাইল তৈরি করতে পারবেন। রাখতে পারবেন আপনার দরকারি সব প্রেসক্রিপশন ও ডায়াগনস্টিক রিপোর্ট। যা প্রয়োজন হলেই ডাক্তারকে শেয়ার বা প্রিন্ট করে নিতে পারবেন। আপনহেলথ- সব সময় স্বাস্থ্য বিষয়ক বিভিন্ন আর্টিকেল প্রকাশ করবে।</p>

<p>পাশাপাশি কমন অসুখের লক্ষন ও চিকিৎসা পরামর্শ তুলে ধরবে। যা প্রাথমিকভাবে সবারই উপকারে আসবে। এছাড়া সরাসরি ওয়েবসাইটের health advice ক্লিক করে পেয়ে যাবেন দরকারি সব তথ্য। </p>
<p>আপনহেলথ- প্লাটফর্মে সম্মানিত চিকিৎসকরাও সহজে যুক্ত হতে পারবেন। চিকিৎসক আর রোগীর একটা সেতুবন্ধন তৈরি হবে এখানে। আপনাদের রোগী দেখার সময়, যোগাযোগের জন্য কন্টাক্ট নম্বর, ইমেইল, এড্রেস এবং কনসাল্টেশন ফী উমুক্ত রাখতে পারবেন, রোগী সহজে যোগাযোগ করে সেবা নিতে পারবে।</p>

<p>আপনহেলথ- ওয়েবসাইটে থাকবে জরুরি চিকিৎসা সেবা, ব্লাড ব্যাংক সহ আরও অনেক কিছু।</p>


<br/>
<p>লিংকটি অন্যদের সাথে শেয়ার করার অনুরোধ রইলো। </p>
</section>

@endsection
