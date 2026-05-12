<div>
    @php
    $email =\App\Models\EmailTemplete::where('templete','=', 'new_doctor')->first();
    echo $email->description;
    echo $email->footer;
    @endphp
    <p>{{ $mail['content'] }}</p>
    <p>Your Email: {{ $mail['email'] }}</p>
    <p>Your Password is: {{ $mail['password'] }}</p>
    @php
    echo $email->footer;
    @endphp
</div>
