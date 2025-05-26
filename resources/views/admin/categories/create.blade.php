@extends('admin.layouts.index')

@section('content')
<div class="container">
    <h2>Thêm danh mục</h2>
    <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
        @include('admin.categories.form')
    </form>
</div>
@endsection
