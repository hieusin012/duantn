@section('title', $product->name)
@extends('clients.layouts.master')
@section('title', $product->name)

@section('content')
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12 col-12 product-layout-img mb-4 mb-md-0">
            <!-- Product Horizontal -->
            <div class="product-details-img product-horizontal-style">
                <!-- Product Main -->
                <div class="zoompro-wrap">
                    <!-- Product Image -->
                    <div class="zoompro-span">
                        <img id="zoompro" class="zoompro" src="{{ asset($product->image) }}" data-zoom-image="{{ asset($product->image) }}" alt="{{ $product->name }}" width="400" height="516" />
                    </div>
                    <!-- End Product Image -->
                    <!-- Product Buttons -->
                    <div class="product-buttons">
                        <a href="#;" class="btn btn-primary prlightbox" data-bs-toggle="tooltip" data-bs-placement="top" title="Zoom Image">
                            <i class="icon anm anm-expand-l-arrows"></i>
                        </a>
                    </div>
                    <!-- End Product Buttons -->
                </div>
                <!-- End Product Main -->

                <!-- Product Thumb -->
                <div class="product-thumb product-horizontal-thumb mt-3">
                    <div id="gallery" class="product-thumb-horizontal">
                        @if(!empty($productImages))
                            @foreach($productImages as $image)
                                <a data-image="{{ asset($image->image) }}" data-zoom-image="{{ asset($image->image) }}" class="slick-slide">
                                    <img class="blur-up lazyload" data-src="{{ asset($image->image) }}" src="{{ asset($image->image) }}" alt="product" width="80" height="103" />
                                </a>
                            @endforeach
                        @else
                            <a data-image="{{ asset($product->image) }}" data-zoom-image="{{ asset($product->image) }}" class="slick-slide">
                                <img class="blur-up lazyload" data-src="{{ asset($product->image) }}" src="{{ asset($product->image) }}" alt="product" width="80" height="103" />
                            </a>
                        @endif
                    </div>
                </div>
                <!-- End Product Thumb -->

                <!-- Product Gallery -->
                <div class="lightboximages">
                    <a href="{{ asset($product->image) }}" data-size="1000x1280"></a>
                    @if(!empty($productImages))
                        @foreach($productImages as $image)
                            <a href="{{ asset($image->image) }}" data-size="1000x1280"></a>
                        @endforeach
                    @endif
                </div>
                <!-- End Product Gallery -->
            </div>
            <!-- End Product Horizontal -->
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-12 product-layout-info">
            <!-- Product Details -->
            <div class="product-single-meta">
                <h2 class="product-main-title">{{ $product->name }}</h2>
                <!-- Product Price -->
                <div class="product-price d-flex-center my-3">
                    <span class="price">{{ number_format($product->price, 0, ',', '.') }} VNĐ</span>
                </div>
                <!-- End Product Price -->
                <hr>
                <!-- Sort Description -->
                <div class="sort-description">{!! $product->description ?? 'Không có mô tả.' !!}</div>
                <!-- End Sort Description -->
            </div>
            <!-- End Product Details -->

            <!-- Product Form -->
            <form method="post" action="#" class="product-form product-form-border hidedropdown">
                <!-- Swatches -->
                <div class="product-swatches-option">
                    <!-- Swatches Color -->
                    @if(!empty($availableColors))
                        <div class="product-item swatches-image w-100 mb-4 swatch-0 option1" data-option-index="0">
                            <label class="label d-flex align-items-center">Color:<span class="slVariant ms-1 fw-bold">Chọn màu</span></label>
                            <ul class="variants-clr swatches d-flex-center pt-1 clearfix">
                                @foreach($availableColors as $color)
                                    <li class="swatch x-large available" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $color->name }}">
                                        <img src="{{ asset('assets/images/colors/' . ($color->image ?? 'default-color.jpg')) }}" alt="{{ $color->name }}" width="40" height="40" />
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <!-- End Swatches Color -->
                    <!-- Swatches Size -->
                    @if(!empty($availableSizes))
                        <div class="product-item swatches-size w-100 mb-4 swatch-1 option2" data-option-index="1">
                            <label class="label d-flex align-items-center">Size:<span class="slVariant ms-1 fw-bold">Chọn kích cỡ</span></label>
                            <ul class="variants-size size-swatches d-flex-center pt-1 clearfix">
                                @foreach($availableSizes as $size)
                                    <li class="swatch x-large available" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $size->name }}">
                                        <span class="swatchLbl">{{ $size->name }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <!-- End Swatches Size -->
                </div>
                <!-- End Swatches -->

                <!-- Product Action -->
                <div class="product-action w-100 d-flex-wrap my-3 my-md-4">
                    <!-- Product Quantity -->
                    <div class="product-form-quantity d-flex-center">
                        <div class="qtyField">
                            <a class="qtyBtn minus" href="#;"><i class="icon anm anm-minus-r"></i></a>
                            <input type="text" name="quantity" value="1" class="product-form-input qty" />
                            <a class="qtyBtn plus" href="#;"><i class="icon anm anm-plus-r"></i></a>
                        </div>
                    </div>
                    <!-- End Product Quantity -->
                    <!-- Product Add -->
                    <div class="product-form-submit addcart fl-1 ms-3">
                        <button type="submit" name="add" class="btn btn-secondary product-form-cart-submit">
                            <span>THÊM VÀO GIỎ HÀNG</span>
                        </button>
                    </div>
                    <!-- Product Add -->
                    <!-- Product Buy -->
                    <div class="product-form-submit buyit fl-1 ms-3">
                        <button type="submit" class="btn btn-primary proceed-to-checkout"><span>MUA NGAY</span></button>
                    </div>
                    <!-- End Product Buy -->
                </div>
                <!-- End Product Action -->
            </form>
            <!-- End Product Form -->

            <!-- Product Info -->
            <div class="userViewMsg featureText" data-user="20" data-time="11000">
                <i class="icon anm anm-eye-r"></i><b class="uersView">21</b> Người đang xem sản phẩm này
            </div>
            <!-- End Product Info -->
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/jquery.zoom.min.js') }}"></script>
    <script src="{{ asset('assets/js/slick.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Initialize Zoom
            $('#zoompro').zoom();

            // Initialize Thumb Slider
            $('#gallery').slick({
                slidesToShow: 5,
                slidesToScroll: 1,
                infinite: true,
                arrows: true,
                responsive: [
                    { breakpoint: 1024, settings: { slidesToShow: 4 } },
                    { breakpoint: 600, settings: { slidesToShow: 3 } },
                    { breakpoint: 480, settings: { slidesToShow: 2 } }
                ]
            });

            // Initialize Lightbox
            $('.lightboximages a').fancybox();
        });
    </script>
@endsection