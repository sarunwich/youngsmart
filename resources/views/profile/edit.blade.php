@extends('layouts.user')
@section('title')
    {{ 'Edit Profile' }} @parent
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
                {{-- <div class="card">
                    <div class="card-header bg-custom">
                        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                            {{ __('Profile') }}
                        </h2>
                    </div>

                    <div class="card-body"> --}}
                        {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot> --}}

                        <div class="py-12">
                            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                                    <div class="max-w-xl">
                                        @include('profile.partials.update-profile-information-form')
                                        
                                    </div>
                                </div>

                                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                                    <div class="max-w-xl">
                                        @include('profile.partials.update-password-form')
                                    </div>
                                </div>

                                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                                    <div class="max-w-xl">
                                        {{-- @include('profile.partials.delete-user-form') --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    {{-- </div>
                </div> --}}
            </div>
        </div>
    @endsection
    @push('scripts')
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(".alert").delay(2000).slideUp(500, function() {
            $(this).alert('close');
        });
    </script>
    @endpush
