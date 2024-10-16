@extends('layouts.app')

@section('content')

    <div class="mt-5">
        <div class="text-center">
            <p class="mt-4 text-lg">Thank you for registering!</p>
            <p class="mt-4 text-lg">Your account has been successfully created.</p>

            <button class="btn btn-primary mt-5">
                <a href="{{ url('/dashboard') }}" class="mt-6 inline-block bg-blue-500 px-4 py-2 rounded-md">Go to Homepage</a></div>
            </button>
            
    </div>

@endsection