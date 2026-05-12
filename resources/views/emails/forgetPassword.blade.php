<div>
    @php
    $email =\App\Models\EmailTemplete::where('templete','=', 'forget_password')->first();
    echo $email->description;
    echo $email->footer;
    @endphp
    <a href="{{ route('reset.password.get', $token) }}">Reset Password</a>
    @php
    echo $email->footer;
    @endphp
</div>

