@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
    <div class="max-w-2xl mx-auto space-y-8">
        <div class="bg-white shadow rounded-lg p-6">
            @include('profile.partials.update-profile-information-form')
        </div>
        <div class="bg-white shadow rounded-lg p-6">
            @include('profile.partials.update-password-form')
        </div>
        <div class="bg-white shadow rounded-lg p-6">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
@endsection
