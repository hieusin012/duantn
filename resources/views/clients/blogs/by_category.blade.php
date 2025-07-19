@extends('clients.layouts.master')

@section('title', 'Danh mục: ' . $category->name)

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center">Danh mục: {{ $category->name }}</h2>

    @if ($blogs->count())
        <div class="row">
            @foreach ($blogs as $blog)
                <div class="col-md-3 col-6 mb-4">
                    <div class="product-box card border-0 bg-light rounded-3 shadow-sm position-relative overflow-hidden h-100">

                        {{-- Blog Image --}}
                        <div class="product-image position-relative">
                            <a href="{{ route('client.blogs.show', $blog->slug) }}">
                                <img src="{{ asset('storage/' . ($blog->image ?? 'assets/images/blog-placeholder.jpg')) }}"
                                    class="card-img-top"
                                    alt="{{ $blog->title }}">
                            </a>
                        </div>

                        {{-- Blog Info --}}
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $blog->title }}</h5>

                            <div class="product-review mb-2 text-muted small">
                                {{ $blog->created_at->format('d/m/Y') }}
                            </div>

                            <p class="card-text">{{ Str::limit(strip_tags($blog->description), 100) }}</p>

                            <a href="{{ route('client.blogs.show', $blog->slug) }}" class="btn btn-primary btn-sm">
                                <i class="icon anm anm-arrow-right me-1"></i> Đọc tiếp
                            </a>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $blogs->links() }}
        </div>
    @else
        <div class="alert alert-info text-center">Không có bài viết nào trong danh mục này.</div>
    @endif
</div>
@endsection
