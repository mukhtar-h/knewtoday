@extends('layouts.admin')

@section('title', 'KNEWTODAY — Edit Post')

@section('page_title', 'Edit Post')
@section('page_subtitle', 'Update your story.')

@push('head')
<link rel="stylesheet" href="https://unpkg.com/trix@2.0.0/dist/trix.css">
@endpush

@push('scripts')
<script src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>
@endpush

@section('content')

<form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data">

    @csrf

    @method('PUT')

    @include('admin.posts._form')

</form>

@endsection