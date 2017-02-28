@extends('layout')

@section('content')

    @include('partials.errors')

    <p style="margin-bottom: 15px;">{{ $user->username }}</p>
    <p style="margin-bottom: 15px;">
        {{ $user->email }}
        <a id="ce-link" style="cursor: pointer;" modal="ce-modal">change email</a>
    </p>
    <div class="modal" id="ce-modal">
        <div class="modal-content small">
            <div class="modal-header">
                <h4>Change Email</h4>
            </div>
            <div class="modal-body">
                <form action="/account/change-email" method="post" id="ce-form">
                    {{ csrf_field() }}
                    <input name="password" placeholder="password" type="password" style="width: 100%; box-sizing: border-box;">
                    <input name="email" placeholder="new email" type="text" style="width: 100%; box-sizing: border-box;">
                    <button type="submit" class="btn btn-primary" style="float: right;">Change Email</button>
                    <button type="reset" class="btn btn-gray close-modal" style="margin-right: 15px;">Cancel</button>
                </form>
            </div>
        </div>
    </div>

    <p style="margin-bottom: 15px;"><a id="cp-link" style="cursor: pointer;" modal="cp-modal">change password</a></p>
    <div class="modal" id="cp-modal">
        <div class="modal-content small">
            <div class="modal-header">
                <h4>Change Password</h4>
            </div>
            <div class="modal-body">
                <form action="/account/change-password" method="post" id="cp-form">
                    {{ csrf_field() }}
                    <input name="old_password" placeholder="old password" type="password" style="width: 100%; box-sizing: border-box;">
                    <input name="new_password" placeholder="new password" type="password" style="width: 100%; box-sizing: border-box;">
                    <input name="new_password_confirmation" placeholder="confirm password" type="password" style="width: 100%; box-sizing: border-box;">
                    <button type="submit" class="btn btn-primary" style="float: right;">Change Password</button>
                    <button type="reset" class="btn btn-gray close-modal" style="margin-right: 15px;">Cancel</button>
                </form>
            </div>
        </div>
    </div>

    <p style="margin-bottom: 15px;"><a id="cp-link" style="cursor: pointer;" modal="da-modal">deactivate account</a></p>
    <div class="modal" id="da-modal">
        <div class="modal-content small">
            <div class="modal-header">
                <h4>Deactivate Your Account</h4>
            </div>
            <div class="modal-body">
                <form action="/account/deactivate-account" method="post" id="da-form">
                    {{ csrf_field() }}
                    <input name="password" placeholder="password" type="password" style="width: 100%; box-sizing: border-box;">
                    <button type="submit" class="btn btn-danger" style="float: right;">Deactivate Account</button>
                    <button type="reset" class="btn btn-gray close-modal" style="margin-right: 15px;">Cancel</button>
                </form>
            </div>
        </div>
    </div>
@endsection
