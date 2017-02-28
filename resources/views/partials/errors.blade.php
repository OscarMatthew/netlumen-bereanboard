@if (count($errors))
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger">
            <a class="close-alert"><i class="fa fa-fw fa-times"></i></a>
            {{ $error }}
        </div>
    @endforeach
@endif
