@extends('layouts.admin')

@section('title', 'KNEWTODAY — New Tag')

@section('page_title', 'New Tag')
@section('page_subtitle', 'Create a new tag to group related stories.')

@section('content')

@if(session('status'))
<div class="mb-4 text-xs px-3 py-2 rounded-lg bg-emerald-500/10 border border-emerald-500/50 text-emerald-100">
    {{ session('status') }}
</div>
@endif

<form method="POST" action="{{ route('admin.tags.store') }}" class="space-y-4">
    @csrf

    @php
    $tag = $tag ?? new \App\Models\Tag();
    @endphp

    @include('admin.tags._form', [
    'tag' => $tag,
    'submitLabel' => 'Create Tag',
    ])
</form>
@endsection