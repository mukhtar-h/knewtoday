@extends('layouts.admin')

@section('title', 'KNEWTODAY — New Post')

@section('page_title', 'New Post')
@section('page_subtitle', 'Write a new story for KNEWTODAY.')

@push('head')
<link rel="stylesheet" href="https://unpkg.com/trix@2.0.0/dist/trix.css">
@endpush

@push('scripts')
<script src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>
@endpush

@section('content')

<form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">

    @csrf

    @php
    // Fake empty post for create
    $post = new \App\Models\Post();
    $selectedTagIds = old('tags', []);
    @endphp

    @include('admin.posts._form')

</form>

@endsection