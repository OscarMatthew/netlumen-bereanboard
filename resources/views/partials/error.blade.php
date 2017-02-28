@if (Session::has('error'))
    <div class="alert alert-danger">
        <a class="close-alert"><i class="i-times"></i></a>
        {{ session('error') }}
    </div>
@endif
