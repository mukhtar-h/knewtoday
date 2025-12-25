@extends('layouts.admin')

@section('title', 'KNEWTODAY — Edit Tag')

@section('page_title', 'Edit Tag')
@section('page_subtitle', 'Update how this tag groups and describes related stories.')

@section('content')

@if(session('status'))
<div class="mb-4 text-xs px-3 py-2 rounded-lg bg-emerald-500/10 border border-emerald-500/50 text-emerald-100">
    {{ session('status') }}
</div>
@endif

<form method="POST"
    action="{{ route('admin.tags.update', $tag) }}"
    class="space-y-4">
    @csrf
    @method('PUT')

    @include('admin.tags._form', [
    'tag' => $tag,
    'submitLabel' => 'Save Changes',
    ])
</form>
@endsection