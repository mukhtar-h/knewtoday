@extends('layouts.admin')

@section('title', 'KNEWTODAY — New Category')

@section('page_title', 'New Category')
@section('page_subtitle', 'Create a new theme to group related stories.')

@section('content')

@if(session('status'))
<div class="mb-4 text-xs px-3 py-2 rounded-lg bg-emerald-500/10 border border-emerald-500/50 text-emerald-100">
    {{ session('status') }}
</div>
@endif

<form method="POST" action="{{ route('admin.categories.store') }}" class="space-y-4">
    @csrf

    @php
    // empty model for the shared form
    $category = $category ?? new \App\Models\Category();
    @endphp

    @include('admin.categories._form', [
    'category' => $category,
    'submitLabel' => 'Create Category',
    ])
</form>
@endsection