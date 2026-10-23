<x-app-layout>
    <x-slot name="eyebrow">Akun</x-slot>
    <x-slot name="header">Profil</x-slot>
    <x-slot name="subtitle">Perbarui data akun dan password kamu.</x-slot>

    <div class="stack" style="max-width: 760px">
        <div class="card profile-card">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="card profile-card">
            @include('profile.partials.update-password-form')
        </div>

        <div class="card profile-card">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</x-app-layout>
