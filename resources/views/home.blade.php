@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Hello {{ $user->type() }} {{ $user->name }}</div>

                <div class="card-body">
                    @if ($user->role === \App\User::ROLE_ADMIN)
                        {{-- role admin--}}
                    @elseif ($user->role === \App\User::ROLE_REP)
                        {{-- role representative --}}
                    @else
                    {{-- role user --}}
                        {{-- private info section --}}
                        <div class="container">
                            <h2>Personal info section</h2>
                            <form method="POST" action="{{ route('user.profile') }}">
                                @csrf

                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $user->name }}" autofocus>

                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>

                                    <div class="col-md-6">
                                        <input id="email" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $user->email }}" autofocus>

                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Update') }}
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <h2>
                                Finance
                            </h2>

                            <form method="POST" action="{{ route('user.balance') }}">
                                @csrf

                                <div class="form-group row">
                                    <label for="amount" class="col-md-4 col-form-label text-md-right">{{ __('Amount') }}</label>

                                    <div class="col-md-6">
                                        <input id="amount" type="number" class="form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}" name="amount" value="{{ $user->balance->balance }}" autofocus>

                                        @if ($errors->has('amount'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->get('amount') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-3 offset-md-4">
                                        <button type="submit" class="btn btn-primary" name="deposit" value="true">
                                            {{ __('Deposit') }}
                                        </button>
                                    </div>

                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn-primary" name="withdraw" value="true">
                                            {{ __('Withdraw') }}
                                        </button>
                                    </div>

                                </div>
                            </form>

                        </div>
                    @endif

                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
