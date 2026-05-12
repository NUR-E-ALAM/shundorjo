<div>
    @php
    $email =\App\Models\EmailTemplete::where('templete','=', 'new_doctor')->first();
    echo $email->description;
    echo $email->footer;
    @endphp
    <h1>Your Phone: {{ $mail['phone'] }}</h1>
    <h1>Your Password is: {{ $mail['msg'] }}</h1>
    @php
    echo $email->footer;
    @endphp
</div>
