{{-- resources/views/components/app-layout.blade.php --}}
@props(['title'])

@if(auth()->user()->role === 'super-admin')
    {{-- Remplace 'role' par ta colonne de rôle (ex: is_superadmin) --}}
    <x-super-admin-layout :title="$title">
        {{ $slot }}
    </x-super-admin-layout>
@else
    <x-admin-layout :title="$title">
        {{ $slot }}
    </x-admin-layout>
@endif