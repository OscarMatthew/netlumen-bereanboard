@extends('layout')

@section('content')
    @include('partials.errors')
    @include('partials.success')

    <p style="margin-bottom: 15px;">
        {{ $user->username }}{{ $user->active === 0 ? '\'s account has been deactivated.' : '' }}
        @if ($user->active !== 0 && $user->role !== 'user')
            <span class="label label-{{ $user->role === 'moderator' ? 'gray' : 'primary' }}" style="margin: 0 5px;">
                {{ $user->role }}
            </span>
        @endif
        @can('edit-users')
            @if($user->role !== 'admin')
                <a style="cursor: pointer;" modal="cr-modal">change role</a>
                <div class="modal" id="cr-modal">
                    <div class="modal-content small">
                        <div class="modal-header">
                            <h4>Change Role</h4>
                        </div>
                        <div class="modal-body">
                            <form action="/users/{{ $user->id }}" method="post">
                                {{ method_field('patch') }}
                                {{ csrf_field() }}
                                <select name="role" style="width: 100%; box-sizing: border-box;">
                                    <option value="user"{{ $user->role === 'user' ? ' selected' : '' }}>user</option>
                                    <option value="moderator"{{ $user->role === 'moderator' ? ' selected' : '' }}>moderator</option>
                                </select>
                                <button type="submit" class="btn btn-primary" style="float: right;">Change Role</button>
                                <button type="reset" class="btn btn-gray close-modal" style="margin-right: 15px;">Cancel</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        @endcan
    </p>
    @can('edit-user', $user)
        <p style="margin-bottom: 15px;">
            {{ $user->email }}
            <a style="cursor: pointer;" modal="ce-modal">change email</a>
        </p>
        <div class="modal" id="ce-modal">
            <div class="modal-content small">
                <div class="modal-header">
                    <h4>Change Email</h4>
                </div>
                <div class="modal-body">
                    <form action="/users/{{ $user->id }}" method="post">
                        {{ method_field('patch') }}
                        {{ csrf_field() }}
                        <input name="email" placeholder="new email" type="email" style="width: 100%; box-sizing: border-box;" required>
                        <button type="submit" class="btn btn-primary" style="float: right;">Change Email</button>
                        <button type="reset" class="btn btn-gray close-modal" style="margin-right: 15px;">Cancel</button>
                    </form>
                </div>
            </div>
        </div>

        <p style="margin-bottom: 15px;"><a style="cursor: pointer;" modal="cp-modal">change password</a></p>
        <div class="modal" id="cp-modal">
            <div class="modal-content small">
                <div class="modal-header">
                    <h4>Change Password</h4>
                </div>
                <div class="modal-body">
                    <form action="/users/{{ $user->id }}" method="post">
                        {{ method_field('patch') }}
                        {{ csrf_field() }}
                        <input name="password" placeholder="new password" type="password" style="width: 100%; box-sizing: border-box;" required>
                        <input name="password_confirmation" placeholder="confirm password" type="password" style="width: 100%; box-sizing: border-box;" required>
                        <button type="submit" class="btn btn-primary" style="float: right;">Change Password</button>
                        <button type="reset" class="btn btn-gray close-modal" style="margin-right: 15px;">Cancel</button>
                    </form>
                </div>
            </div>
        </div>

        <p style="margin-bottom: 15px;"><a style="cursor: pointer;" modal="da-modal">{{ $user->active ? 'de' : '' }}activate account</a></p>
        <div class="modal" id="da-modal">
            <div class="modal-content small">
                <div class="modal-header">
                    <h4>{{ $user->active ? 'Dea' : 'A' }}ctivate Your Account</h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to {{ $user->active ? 'de' : '' }}activate {{ $user->id === Auth::user()->id ? 'your' : 'this' }} account?</p>
                    <form action="/users/{{ $user->id }}" method="post">
                        {{ method_field('patch') }}
                        {{ csrf_field() }}
                        <input type="hidden" name="active" value="{{ $user->active ? '0' : '1' }}">
                        <button type="submit" class="btn btn-danger" style="float: right;">{{ $user->active ? 'Dea' : 'A' }}ctivate Account</button>
                        <button type="reset" class="btn btn-gray close-modal" style="margin-right: 15px;">Cancel</button>
                    </form>
                </div>
            </div>
        </div>

    @endcan
@endsection
