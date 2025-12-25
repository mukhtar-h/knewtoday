@extends('layouts.admin')

@section('title', 'KNEWTODAY — Edit Category')

@section('page_title', 'Edit Category')
@section('page_subtitle', 'Update how this category appears on KNEWTODAY.')

@section('content')

@if(session('status'))
<div class="mb-4 text-xs px-3 py-2 rounded-lg bg-emerald-500/10 border border-emerald-500/50 text-emerald-100">
    {{ session('status') }}
</div>
@endif

<form method="POST"
    action="{{ route('admin.categories.update', $category) }}"
    class="space-y-4">
    @csrf
    @method('PUT')

    @include('admin.categories._form', [
    'category' => $category,
    'submitLabel' => 'Save Changes',
    ])
</form>
@endsection