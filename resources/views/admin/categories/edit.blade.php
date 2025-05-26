@extends('admin.layouts.index')

@section('content')
<div class="container">
    <h2>Sửa danh mục</h2>
    <form action="{{ route('categories.update', $category) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @include('admin.categories.form')
    </form>
</div>
@endsection
