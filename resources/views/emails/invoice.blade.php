<div>
    @php
    $email =\App\Models\EmailTemplete::where('templete','=', 'invoice')->first();
    echo $email->description;
    echo $email->footer;
    @endphp
</div>
