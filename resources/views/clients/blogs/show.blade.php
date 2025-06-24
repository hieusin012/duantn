@extends('client.layouts.master') {{-- Đảm bảo đường dẫn đúng đến file master của bạn --}}

@section('title', $blog->title . ' - Blog Details')

@section('body_class', 'blog-details-page') {{-- Thêm class cho body nếu cần thiết cho CSS --}}

@section('content')
<div id="page-content"> 
    <div class="page-header text-center">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-content-between align-items-center">
                    <div class="page-title"><h1>Blog Details</h1></div>
                    <div class="breadcrumbs"><a href="{{ route('client.home') }}" title="Back to the home page">Home</a><span class="title"><i class="icon anm anm-angle-right-l"></i>Blog</span><span class="main-title fw-bold"><i class="icon anm anm-angle-right-l"></i>{{ $blog->title }}</span></div>
                    </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-3 blog-sidebar sidebar sidebar-bg">
                <div class="sidebar-tags sidebar-sticky clearfix">
                    <div class="sidebar-widget clearfix categories">
                        <div class="widget-title"><h2>Category</h2></div>
                        <div class="widget-content">
                            <ul class="sidebar-categories scrollspy clearfix">
                                {{-- Lấy danh sách category động (ví dụ từ BlogController nếu bạn muốn truyền cả categories) --}}
                                <li class="lvl-1 active"><a href="#" class="site-nav lvl-1">{{ $blog->category->name ?? 'Uncategorized' }} <span class="count">4</span></a></li>
                                {{-- Nếu bạn truyền $categories từ controller:
                                @foreach($categories as $category)
                                    <li class="lvl-1"><a href="#" class="site-nav lvl-1">{{ $category->name }} <span class="count">{{ $category->blogs->count() }}</span></a></li>
                                @endforeach
                                --}}
                            </ul>
                        </div>
                    </div>
                    <div class="sidebar-widget clearfix categories">
                        <div class="widget-title"><h2>Archive</h2></div>
                        <div class="widget-content">
                            <ul class="sidebar-categories scrollspy clearfix">
                                {{-- Lấy danh sách archive động (theo tháng/năm) --}}
                                <li class="lvl-1"><a href="#" class="site-nav lvl-1">{{ $blog->created_at->format('F Y') }}</a></li>
                                {{-- Bạn có thể group các bài viết theo tháng/năm trong Controller và truyền vào đây --}}
                            </ul>
                        </div>
                    </div>
                    <div class="sidebar-widget clearfix">
                        <div class="widget-title"><h2>Recent Posts</h2></div>
                        <div class="widget-content">
                            <div class="list list-sidebar-products">
                                @php
                                    // Lấy 3 bài blog gần đây nhất, ngoại trừ bài hiện tại
                                    $recentBlogs = App\Models\Blog::where('id', '!=', $blog->id)
                                                                ->orderBy('created_at', 'desc')
                                                                ->limit(3)
                                                                ->get();
                                @endphp
                                @foreach($recentBlogs as $recentBlog)
                                <div class="mini-list-item d-flex align-items-center w-100 clearfix">
                                    <div class="mini-image">
                                        <a class="item-link" href="{{ route('client.blogs.show', $recentBlog->slug) }}">
                                            <img class="featured-image blur-up lazyload" data-src="{{ asset('storage/' . $recentBlog->image) }}" src="{{ asset('storage/' . $recentBlog->image) }}" alt="{{ $recentBlog->title }}" width="100" height="100" />
                                        </a>
                                    </div>
                                    <div class="ms-3 details">
                                        <a class="item-title" href="{{ route('client.blogs.show', $recentBlog->slug) }}">{{ $recentBlog->title }}</a>
                                        <div class="item-meta opacity-75"><time datetime="{{ $recentBlog->created_at->format('Y-m-d') }}">{{ $recentBlog->created_at->format('M d, Y') }}</time></div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="sidebar-widget clearfix tags-clouds">
                        <div class="widget-title"><h2>Popular Tags</h2></div>
                        <div class="widget-content">
                            <ul class="tags-list d-flex-wrap">
                                <li class="item"><a class="rounded-3" href="#">Fashion</a></li>
                                <li class="item"><a class="rounded-3" href="#">Shoes</a></li>
                                <li class="item"><a class="rounded-3" href="#">Beauty</a></li>
                                <li class="item"><a class="rounded-3" href="#">Accessories</a></li>
                                <li class="item"><a class="rounded-3" href="#">Trending</a></li>
                            </ul>
                        </div>
                    </div>
                    </div>
                </div>

            <div class="col-12 col-sm-12 col-md-12 col-lg-9 main-col">
                <div class="blog-article"> 
                    <div class="blog-img mb-3">
                        <img class="rounded-0 blur-up lazyload" data-src="{{ asset('storage/' . $blog->image) }}" src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" width="1200" height="700" />
                    </div>
                    <div class="blog-content">
                        <h2 class="h1">{{ $blog->title }}</h2>
                        <ul class="publish-detail d-flex-wrap">                      
                            <li><i class="icon anm anm-user-al"></i> <span class="opacity-75 me-1">Posted by:</span> {{ $blog->user->fullname ?? 'Unknown User' }}</li>
                            <li><i class="icon anm anm-clock-r"></i> <time datetime="{{ $blog->created_at->format('Y-m-d') }}">{{ $blog->created_at->format('M d, Y') }}</time></li>
                            <li><i class="icon anm anm-comments-l"></i> <a href="#">0 Comments</a></li> {{-- Cần tích hợp hệ thống comment để lấy số lượng thực tế --}}
                            <li><i class="icon anm anm-tag-r"></i><span class="opacity-75">Posted in</span><a class="ms-1" href="#">{{ $blog->category->name ?? 'Uncategorized' }}</a></li>
                        </ul>
                        <hr />
                        <div class="content">
                            {!! $blog->content !!} {{-- Dùng {!! !!} để render nội dung HTML từ database, cẩn thận XSS --}}
                        </div>
                        <hr />
                        <div class="row blog-action d-flex-center justify-content-between">
                            <ul class="col-lg-6 tags-list d-flex-center">
                                <li class="item fw-600">Related Tags :</li>
                                <li class="item"><a class="text-link" href="#">{{ $blog->category->name ?? 'General' }},</a></li> {{-- Có thể mở rộng để hiển thị nhiều tags hơn --}}
                            </ul>

                            <div class="col-lg-6 mt-2 mt-lg-0 social-sharing d-flex-center justify-content-lg-end">
                                <span class="sharing-lbl fw-600">Share :</span>
                                <a href="#" class="d-flex-center btn btn-link btn--share share-facebook" data-bs-toggle="tooltip" data-bs-placement="top" title="Share on Facebook"><i class="icon anm anm-facebook-f"></i><span class="share-title d-none">Facebook</span></a>
                                <a href="#" class="d-flex-center btn btn-link btn--share share-facebook" data-bs-toggle="tooltip" data-bs-placement="top" title="Tweet on Twitter"><i class="icon anm anm-twitter"></i><span class="share-title d-none">Twitter</span></a>
                                <a href="#" class="d-flex-center btn btn-link btn--share share-facebook" data-bs-toggle="tooltip" data-bs-placement="top" title="Pin on Pinterest"><i class="icon anm anm-pinterest-p"></i><span class="share-title d-none">Pinterest</span></a>
                                <a href="#" class="d-flex-center btn btn-link btn--share share-facebook" data-bs-toggle="tooltip" data-bs-placement="top" title="Share on Instagram"><i class="icon anm anm-linkedin-in"></i><span class="share-title d-none">Instagram</span></a>
                                <a href="#" class="d-flex-center btn btn-link btn--share share-facebook" data-bs-toggle="tooltip" data-bs-placement="top" title="Share by Email"><i class="icon anm anm-envelope-l"></i><span class="share-title d-none">Email</span></a>
                            </div>
                        </div>
                        <div class="blog-nav d-flex-center justify-content-between mt-3">
                            {{-- Bạn có thể thêm logic để hiển thị bài trước/sau --}}
                            <div class="nav-prev fs-14"><a href="#"><i class="align-middle me-2 icon anm anm-angle-left-r"></i><span class="align-middle">Previous post</span></a></div>
                            <div class="nav-next fs-14"><a href="#"><span class="align-middle">Next post</span><i class="align-middle ms-2 icon anm anm-angle-right-r"></i></a></div>
                        </div>
                        <hr />

                        <div class="author-bio">
                            <div class="author-image d-flex">
                                <a class="author-img" href="#">
                                    {{-- Sử dụng ảnh avatar từ user, nếu không có thì dùng ảnh default --}}
                                    <img class="blur-up lazyload" data-src="{{ asset('storage/' . ($blog->user->avatar ?? 'avatars/default.jpg')) }}" src="{{ asset('storage/' . ($blog->user->avatar ?? 'avatars/default.jpg')) }}" alt="{{ $blog->user->fullname ?? 'Unknown User' }}" width="200" height="200" />
                                </a>
                                <div class="author-info ms-4">
                                    <h4 class="mb-2">{{ $blog->user->fullname ?? 'Unknown User' }}</h4>
                                    <p class="text-muted mb-2">
                                        {{-- Cần đếm số bài viết của user và năm tạo user nếu muốn hiển thị chính xác --}}
                                        <span class="postcount">{{ $blog->user->blogs->count() ?? 0 }} posts</span>
                                        <span class="postsince ms-2">Since {{ $blog->user->created_at->format('Y') ?? 'N/A' }}</span>
                                    </p>
                                    <p class="author-des">{{ $blog->user->introduction ?? 'No introduction available.' }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="blog-comment section">
                            <h2 class="mb-4">Comments (0)</h2> {{-- Cần tích hợp hệ thống comment --}}
                            <ol class="comments-list">
                                {{-- Các comment sẽ được hiển thị ở đây --}}
                            </ol>
                        </div>
                        <div class="formFeilds comment-form form-vertical">
                            <form method="post" action="#"> {{-- Form gửi comment cần xử lý ở backend --}}
                                <h2 class="mb-3">Leave a Comment</h2>
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="commentName" class="d-none">Name</label>
                                            <input type="text" id="commentName" name="contact[name]" placeholder="Name" value="" required />
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="commentEmail" class="d-none">Email</label>
                                            <input type="email" id="commentEmail" name="contact[email]" placeholder="Email" value="" required />                        	
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <label for="commentMessage" class="d-none">Message</label>
                                            <textarea rows="5" id="commentMessage" name="contact[body]" placeholder="Write Comment" required></textarea>
                                        </div>
                                    </div>  
                                </div>
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                        <input type="submit" class="btn btn-lg" value="Post comment">
                                    </div>
                                </div>
                            </form>
                        </div>
                        </div>
                    </div>
            </div>
            </div>
    </div>
    </div>
@endsection