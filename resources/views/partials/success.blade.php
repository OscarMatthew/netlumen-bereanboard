@if (Session::has('success'))
    <div class="alert alert-success">
        <a class="close-alert"><i class="i-times"></i></a>
        {{ session('success') }}
    </div>
@endif
