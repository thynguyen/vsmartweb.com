@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ transmod('members::VerifyEmailAddress') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ transmod('members::AlertSuccessVerifyEmail') }}
                        </div>
                    @endif
{{Auth::user()->username}}
                    {{ transmod('members::NoteVerifyEmailMember3') }}
                    {{ transmod('members::NoteVerifyEmailMember4') }}, <a href="{{ route('verification.resend') }}">{{ transmod('members::NoteVerifyEmailMember5') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
