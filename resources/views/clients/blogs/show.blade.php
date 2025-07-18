@extends('clients.layouts.master')

@section('title', $blog->title . ' - Blog Details')
@section('body_class', 'blog-details-page')

@section('content')
<div id="page-content">
    <div class="page-header text-center">
        <div class="container">
            <div class="row">
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <div class="page-title"><h1>Chi tiết blog</h1></div>
                    <div class="breadcrumbs">
                        <a href="{{ route('client.home') }}">Home</a>
                        <span><i class="icon anm anm-angle-right-l"></i>Blog</span>
                        <span><i class="icon anm anm-angle-right-l"></i>{{ $blog->title }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3">
                <div class="sidebar">
                    <div class="widget">
                        <h4>Danh mục</h4>
                        <ul>
                            <li>{{ $blog->category->name ?? 'Uncategorized' }}</li>
                        </ul>
                    </div>
                    <div class="widget">
                        <h4>Lưu trữ</h4>
                        <ul>
                            <li>{{ $blog->created_at->format('F Y') }}</li>
                        </ul>
                    </div>
                    <div class="widget">
                        <h4>Bài viết gần đây</h4>
                        <ul>
                            @foreach($recentBlogs as $recent)
                                <li>
                                    <a href="{{ route('client.blogs.show', $recent->slug) }}">
                                        <img src="{{ asset('storage/' . $recent->image) }}" width="50" height="50" alt="{{ $recent->title }}">
                                        {{ $recent->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9">
                <div class="blog-post">
                    <img src="{{ asset('storage/' . $blog->image) }}" class="img-fluid mb-4" alt="{{ $blog->title }}">
                    <h2>{{ $blog->title }}</h2>
                    <p class="text-muted">
                        <i class="icon anm anm-user-al"></i> {{ $blog->user->fullname ?? 'Unknown' }} | 
                        <i class="icon anm anm-clock-r"></i> {{ $blog->created_at->format('M d, Y') }} | 
                        <i class="icon anm anm-tag-r"></i> {{ $blog->category->name ?? 'Uncategorized' }}
                    </p>
                    <div class="content mb-4">
                        {!! $blog->content !!}
                    </div>

                    <!-- Author -->
                    <div class="author-box p-3 bg-light">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('storage/' . ($blog->user->avatar ?? 'avatars/default.jpg')) }}" width="80" height="80" class="rounded-circle me-3" alt="{{ $blog->user->fullname }}">
                            <div>
                                <h5>{{ $blog->user->fullname }}</h5>
                                <small>{{ $blog->user->blogs->count() }} posts since {{ $blog->user->created_at->format('Y') }}</small>
                                <p>{{ $blog->user->introduction ?? 'No introduction available.' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Comments Section Placeholder -->
                    <div class="mt-5">
                        <h4>Để lại một bình luận</h4>
                        <form action="#" method="GET">
                            
                            <div class="mb-3">
                                <input type="text" class="form-control" placeholder="Tên..." required>
                            </div>
                            <div class="mb-3">
                                <input type="email" class="form-control" placeholder="Email..." required>
                            </div>
                            <div class="mb-3">
                                <textarea class="form-control" rows="5" placeholder="Bình luận của bạn..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Gửi bình luận</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
