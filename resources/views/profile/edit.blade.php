<<<<<<< HEAD
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
=======
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
>>>>>>> 11bef3afaaf72c1e50919d38cee6d046b0ef42c6
