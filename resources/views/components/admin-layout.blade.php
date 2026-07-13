@props(['pageTitle' => 'Admin Panel'])

@php
    // Admin panel hanya untuk desktop, redirect kalau mobile
    if (config('is_mobile')) {
        abort(403, 'Admin panel hanya bisa diakses melalui desktop.');
    }

    // Cek apakah user adalah admin
    if (! auth()->check() || ! auth()->user()->isAdmin()) {
        abort(403, 'Akses ditolak.');
    }
@endphp

<x-slot:layout>admin</x-slot>

@include('layouts.admin', ['slot' => $slot, 'pageTitle' => $pageTitle])