<div>
    @php
    $email =\App\Models\EmailTemplete::where('templete','=', 'front_order')->first();
    echo $email->description;
    echo $email->footer;
    @endphp
</div>
