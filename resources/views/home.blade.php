@extends('layouts.app')

@section('content')
<div class="container" >
    {{-- <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div> --}}
    <h1>Single Page Application with Vue</h1>
    <router-link to="/product" class="btn btn-info pull-right mb-2">Click Product</router-link>
    <router-view> </router-view>
</div>
@endsection
