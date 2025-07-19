@if ($errors->any())
    <div class="alert alert-light-danger color-danger">
        <strong>Whoops!</strong> Silahkan isi data dengan benar!<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li class="text-danger">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
