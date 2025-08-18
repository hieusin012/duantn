<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\BrandController;

use App\Http\Controllers\ColorController;
use App\Http\Controllers\BannerController;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ThongKeController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Client\ApplyVoucherController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\CartItemController;
use App\Http\Controllers\Client\FacebookController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\GoogleAuthController;

use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\ProductVariantController;


use App\Http\Controllers\Client\ChangePasswordController;
use App\Http\Controllers\Client\ClientCategoryController;
use App\Http\Controllers\Client\ForgetPasswordController;

use App\Http\Controllers\CommentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\AdminReturnRequestController;
use App\Http\Controllers\ShipperController;
use App\Http\Controllers\Client\ProductCommentController;

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/forgot-password', [ForgetPasswordController::class, 'showForgotPassword'])->name('forgot-password');
Route::post('/forgot-password', [ForgetPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ForgetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ForgetPasswordController::class, 'resetPassword'])->name('password.update');
//Google
Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');
//Facebook
Route::middleware('web')->group(function () {
    Route::get('auth/facebook', [FacebookController::class, 'redirectToFacebook'])->name('facebook.redirect');
    Route::get('auth/facebook/callback', [FacebookController::class, 'handleFacebookCallback'])->name('facebook.callback');
});

// Trang Dashboard admin

// Nhóm route admin

// Route::prefix('admin')->middleware('auth', 'admin')->name('admin.')->group(function () { // Nếu dùng bảo vệ url http: 127.0.0.1:8000/admin thì bỏ cmt dòng này. Cmt lại dòng dưới.
    Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('dashboard/chart-data', [DashboardController::class, 'chartData'])->name('dashboard.chartData');


    // Product
    Route::prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('products.index');
        Route::get('/create-products', [ProductController::class, 'create'])->name('products.create');
        Route::post('/create', [ProductController::class, 'store'])->name('products.store');
        Route::get('/show/{id}', [ProductController::class, 'show'])->name('products.show');
        Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/edit/{id}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/destroy/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
        Route::get('/search', [ProductController::class, 'search'])->name('products.search');
        Route::get('/filter', [ProductController::class, 'filter'])->name('products.filter');
        // Route danh sách sản phẩm đã xóa mềm (thùng rác)
        Route::get('/products/trash', [ProductController::class, 'trash'])->name('products.trash');
        // Route khôi phục sản phẩm
        Route::get('/products/restore/{id}', [ProductController::class, 'restore'])->name('products.restore');
        // Route xóa vĩnh viễn một sản phẩm
        Route::delete('/products/force-delete/{id}', [ProductController::class, 'forceDelete'])->name('products.force-delete');
        // Route xóa vĩnh viễn tất cả sản phẩm đã xóa mềm
        Route::delete('/products/force-delete-all', [ProductController::class, 'forceDeleteAll'])->name('products.force-delete-all');
    });

    // XÓA MỀM Product Variant
    Route::get('/product-variants/delete', [ProductVariantController::class, 'delete'])->name('variants.delete');
    Route::get('/product-variants/restore/{id}', [ProductVariantController::class, 'restore'])->name('variants.restore');
    Route::delete('/product-variants/eliminate/{id}', [ProductVariantController::class, 'eliminate'])->name('variants.eliminate');
    Route::delete('/product-variants/all-eliminate', [ProductVariantController::class, 'forceDeleteAll'])->name('variants.all-eliminate');
    // Product Variant
    Route::get('product-variants/search', [ProductVariantController::class, 'search'])->name('variants.search');
    Route::resource('product-variants', ProductVariantController::class);


    // Categories
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::post('/categories/{id}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggleStatus');
    Route::post('/categories/{id}/restore', [CategoryController::class, 'restore'])->name('categories.restore');
    Route::delete('/categories/{id}/force', [CategoryController::class, 'forceDelete'])->name('categories.force-delete');
    //banner
    Route::get('/banners', [BannerController::class, 'index'])->name('banners.index');
    Route::get('/banners/create', [BannerController::class, 'create'])->name('banners.create');
    Route::post('/banners', [BannerController::class, 'store'])->name('banners.store');
    Route::get('/banners/{banner}', [BannerController::class, 'show'])->name('banners.show');
    Route::get('/banners/{banner}/edit', [BannerController::class, 'edit'])->name('banners.edit');
    Route::put('/banners/{banner}', [BannerController::class, 'update'])->name('banners.update');
    Route::delete('/banners/{banner}', [BannerController::class, 'destroy'])->name('banners.destroy');

    // Sizes
    Route::get('/sizes/delete', [SizeController::class, 'delete'])->name('sizes.delete');
    Route::delete('/sizes/all-eliminate', [SizeController::class, 'forceDeleteAll'])->name('sizes.all-eliminate');
    Route::delete('/sizes/eliminate/{id}', [SizeController::class, 'eliminate'])->name('sizes.eliminate');
    Route::get('/sizes/restore/{id}', [SizeController::class, 'restore'])->name('sizes.restore');
    Route::get('/sizes', [SizeController::class, 'index'])->name('sizes.index');
    Route::get('/sizes/create', [SizeController::class, 'create'])->name('sizes.create');
    Route::post('/sizes', [SizeController::class, 'store'])->name('sizes.store');
    Route::get('/sizes/{size}', [SizeController::class, 'show'])->name('sizes.show');
    Route::get('/sizes/{size}/edit', [SizeController::class, 'edit'])->name('sizes.edit');
    Route::put('/sizes/{size}', [SizeController::class, 'update'])->name('sizes.update');
    Route::delete('/sizes/{size}', [SizeController::class, 'destroy'])->name('sizes.destroy');

    // voucher

    Route::resource('vouchers', VoucherController::class);


    // Users
    Route::get('/users/deleted', [UserController::class, 'deleted'])->name('users.deleted');
    Route::get('/users/restore/{id}', [UserController::class, 'restore'])->name('users.restore');
    Route::delete('/users/eliminate/{id}', [UserController::class, 'eliminate'])->name('users.eliminate');
    Route::delete('/users/all-eliminate', [UserController::class, 'forceDeleteAll'])->name('users.all-eliminate');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    //color
    Route::get('/colors', [ColorController::class, 'index'])->name('colors.index');
    Route::get('/colors/create', [ColorController::class, 'create'])->name('colors.create');
    Route::post('/colors', [ColorController::class, 'store'])->name('colors.store');
    Route::get('/colors/delete', [ColorController::class, 'delete'])->name('colors.delete');
    Route::delete('/colors/all-eliminate', [ColorController::class, 'forceDeleteAll'])->name('colors.all-eliminate');
    Route::delete('/colors/eliminate/{id}', [ColorController::class, 'eliminate'])->name('colors.eliminate');
    Route::get('/colors/restore/{id}', [ColorController::class, 'restore'])->name('colors.restore');
    Route::delete('/colors/{id}', [ColorController::class, 'destroy'])->name('colors.destroy');
    Route::get('/colors/{id}/edit', [ColorController::class, 'edit'])->name('colors.edit');
    Route::put('/colors/{id}', [ColorController::class, 'update'])->name('colors.update');


    //brands
    Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
    Route::get('/brands/create', [BrandController::class, 'create'])->name('brands.create');
    Route::post('/brands', [BrandController::class, 'store'])->name('brands.store');
    Route::get('/brands/delete', [BrandController::class, 'delete'])->name('brands.delete');
    Route::delete('/brands/eliminate/{id}', [BrandController::class, 'eliminate'])->name('brands.eliminate');
    Route::delete('/brands/all-eliminate', [BrandController::class, 'forceDeleteAll'])->name('brands.all-eliminate');
    Route::delete('/brands/{brand}', [BrandController::class, 'destroy'])->name('brands.destroy');
    Route::get('/brands/{brand}/edit', [BrandController::class, 'edit'])->name('brands.edit');
    Route::put('/brands/{brand}', [BrandController::class, 'update'])->name('brands.update');
    Route::get('/brands/restore/{id}', [BrandController::class, 'restore'])->name('brands.restore');


    //order
    Route::resource('shiptypes', \App\Http\Controllers\ShipTypeController::class);
    Route::resource('orders', App\Http\Controllers\OrderController::class);
    Route::get('orders-report', [OrderController::class, 'report'])->name('orders.report');
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::get('/print/orders/{id}', [OrderController::class, 'print'])->name('orders.print');




    //Blog
    Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
    Route::get('/blogs/create', [BlogController::class, 'create'])->name('blogs.create');
    Route::post('/blogs', [BlogController::class, 'store'])->name('blogs.store');
    Route::get('/blogs/delete', [BlogController::class, 'delete'])->name('blogs.delete');
    Route::get('/blogs/restore/{id}', [BlogController::class, 'restore'])->name('blogs.restore');
    Route::delete('/blogs/eliminate/{id}', [BlogController::class, 'eliminate'])->name('blogs.eliminate');
    Route::delete('/blogs/all-eliminate', [BlogController::class, 'forceDeleteAll'])->name('blogs.all-eliminate');
    Route::get('/blogs/{blog}/edit', [BlogController::class, 'edit'])->name('blogs.edit');
    Route::put('/blogs/{blog}', [BlogController::class, 'update'])->name('blogs.update');
    Route::delete('/blogs/{blog}', [BlogController::class, 'destroy'])->name('blogs.destroy');
    Route::get('/blogs/{blog}', [BlogController::class, 'show'])->name('blogs.show');
    //shipper
    // Nhóm route cho shipper
    Route::prefix('shipper')->middleware(['auth'])->name('shipper.orders.')->group(function () {
        Route::get('/orders', [\App\Http\Controllers\ShipperOrderController::class, 'index'])->name('index');

        Route::get('/orders/create', [\App\Http\Controllers\ShipperOrderController::class, 'create'])->name('create');
        Route::post('/orders/store', [\App\Http\Controllers\ShipperOrderController::class, 'store'])->name('store');

        Route::get('/orders/accept/{id}', [\App\Http\Controllers\ShipperOrderController::class, 'accept'])->name('accept');
        Route::get('/orders/complete/{id}', [\App\Http\Controllers\ShipperOrderController::class, 'complete'])->name('complete');
    });

    Route::prefix('shipper')->middleware(['auth'])->name('shipper.persons.')->group(function () {
        Route::get('/persons', [ShipperController::class, 'index'])->name('index');
        Route::get('/persons/create', [ShipperController::class, 'create'])->name('create');
        Route::post('/persons/store', [ShipperController::class, 'store'])->name('store');
        Route::get('/persons/{id}/edit', [ShipperController::class, 'edit'])->name('edit');
        Route::put('/persons/{id}', [ShipperController::class, 'update'])->name('update');
        Route::delete('/persons/{id}', [ShipperController::class, 'destroy'])->name('destroy');
        Route::get('/persons/{id}', [ShipperController::class, 'show'])->name('show');
    });

    //comment
    Route::resource('comments', CommentController::class);

    // Yêu cầu trả hàng (Admin)
    Route::prefix('return-requests')->name('return-requests.')->group(function () {
        Route::get('/', [AdminReturnRequestController::class, 'index'])->name('index'); // admin.return-requests.index
        Route::get('/{id}', [AdminReturnRequestController::class, 'show'])->name('show'); // admin.return-requests.show
        Route::put('/{id}/update', [AdminReturnRequestController::class, 'update'])->name('update'); // admin.return-requests.update
    });
    //xóa đoạn chat
    Route::delete('/chat/delete-conversation/{userId}', [MessageController::class, 'deleteConversationWithUser'])->name('chat.deleteConversation');
});

// Chatbx admin
Route::middleware('auth')->group(function () {
    Route::get('/admin/chat', [MessageController::class, 'index'])->name('admin.chat');
    Route::get('/admin/chat/messages/{userId}', [MessageController::class, 'fetchMessages']);
    Route::post('/admin/chat/send', [MessageController::class, 'sendMessage']);
    Route::delete('/admin/chat/{userId}', [MessageController::class, 'destroy'])->name('admin.chat.destroy');
});


// Quản lý nhà cung cấp
Route::prefix('admin')->name('admin.')->group(function () {
    // Resource CRUD
    Route::resource('suppliers', SupplierController::class)->except(['show']);
    // Thêm các route quản lý dữ liệu đã xóa
    Route::get('suppliers/trash', [SupplierController::class, 'trash'])->name('suppliers.trash'); // Trang danh sách đã xóa
    Route::get('suppliers/trash', [SupplierController::class, 'trash'])->name('suppliers.delete');
    Route::post('suppliers/{id}/restore', [SupplierController::class, 'restore'])->name('suppliers.restore'); // Khôi phục
    Route::delete('suppliers/{id}/eliminate', [SupplierController::class, 'eliminate'])->name('suppliers.eliminate'); // Xóa vĩnh viễn
    Route::delete('suppliers/all/eliminate', [SupplierController::class, 'eliminateAll'])->name('suppliers.all-eliminate'); // Xóa tất cả
});


// Quản lý nhập hàng(Phiếu nhập)
Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    Route::get('/imports/delete', [\App\Http\Controllers\ImportController::class, 'delete'])->name('imports.delete');
    Route::get('/imports/restore/{id}', [\App\Http\Controllers\ImportController::class, 'restore'])->name('imports.restore');
    Route::delete('/imports/eliminate/{id}', [\App\Http\Controllers\ImportController::class, 'eliminate'])->name('imports.eliminate');
    Route::delete('/imports/all-eliminate', [\App\Http\Controllers\ImportController::class, 'forceDeleteAll'])->name('imports.all-eliminate');
    Route::resource('imports', \App\Http\Controllers\ImportController::class);
});


// Yêu thích sản phẩm
Route::middleware('auth')->group(function () {
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::delete('/wishlist/remove', [WishlistController::class, 'remove'])->name('wishlist.remove')->middleware('auth');
});
Route::middleware('auth')->get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');

// Tra cứu đơn hàng
Route::get('/tra-cuu-don-hang', [App\Http\Controllers\OrderLookupController::class, 'form'])->name('order.lookup.form');
Route::post('/tra-cuu-don-hang', [App\Http\Controllers\OrderLookupController::class, 'lookup'])->name('order.lookup');


// Quản lý danh mục bài viết
use App\Http\Controllers\BlogCategoryController;

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/blog-categories/delete', [BlogCategoryController::class, 'delete'])->name('blog-categories.delete');
    Route::get('/blog-categories/restore/{id}', [BlogCategoryController::class, 'restore'])->name('blog-categories.restore');
    Route::delete('/blog-categories/eliminate/{id}', [BlogCategoryController::class, 'eliminate'])->name('blog-categories.eliminate');
    Route::delete('/blog-categories/all-eliminate', [BlogCategoryController::class, 'forceDeleteAll'])->name('blog-categories.all-eliminate');
    Route::resource('blog-categories', BlogCategoryController::class);
});

//quản lý tồn kho 
use App\Http\Controllers\InventoryController;

Route::get('/admin/inventory', [InventoryController::class, 'index'])->name('admin.inventory.index');
// Route cho sản phẩm theo danh mục Client
Route::get('/product/danh-muc/{slug}', [\App\Http\Controllers\Client\ProductController::class, 'showByCategory'])->name('products.byCategory');

// Trang client (không nằm trong admin)
use App\Http\Controllers\Client\BlogController as ClientBlogController;
use App\Http\Controllers\Client\ContactController as ClientContactController;
use App\Http\Controllers\Client\ProductController as ClientProductController;
use App\Http\Controllers\Client\VoucherController as ClientVoucherController;
use App\Http\Controllers\Client\CheckoutController;
use App\Http\Controllers\Client\ClientOrderController;
use App\Http\Controllers\VnpayController;

// Nhóm các routes yêu cầu xác thực người dùng

// Sửa trong web.php
Route::get('/', [HomeController::class, 'index'])->name('client.home'); // Sửa 'home' thành 'client.home'


// Tìm kiếm sản phẩm
Route::get('/products/search', [ClientProductController::class, 'search'])->name('client.products.search');


// Route::get('/products/search', [ClientProductController::class, 'search'])->name('clients.products.search');


// Trang chi tiết sản phẩm (dùng slug để SEO tốt hơn)// Trang chi tiết sản phẩm (dùng slug)
Route::get('san-pham/{slug}', [ClientProductController::class, 'show'])->name('client.products.show');
// biến thể
// routes/web.php
Route::get('/product/variant-info', [ClientProductController::class, 'getVariantInfo'])->name('product.variant.info');


// comment
Route::post('/comments/client-store', [CommentController::class, 'storeClient'])->name('client.comments.store')->middleware('auth');

//contact
Route::get('/contact', [ClientContactController::class, 'showForm'])->name('client.contact');
Route::post('/contact', [ClientContactController::class, 'handleSubmit'])->name('contact.submit');

//category
Route::get('/danh-muc/{slug}', [ClientCategoryController::class, 'show'])->name('client.categories.show');

//blog

Route::get('/blog', [ClientBlogController::class, 'index'])->name('client.blog'); // Sửa từ clients.blog
Route::get('/blog/{slug}', [App\Http\Controllers\Client\BlogController::class, 'show'])->name('client.blogs.show');


//products

// Trang danh sách sản phẩm
Route::get('/products', [ClientProductController::class, 'index'])->name('client.products.index');

//cart
Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('client.cart');
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('client.cart.add');
    Route::post('/cart/update', [CartController::class, 'updateCart'])->name('client.cart.update');
    Route::delete('/cart/remove/{productId}', [CartController::class, 'removeFromCart'])->name('client.cart.remove');
    Route::get('/cart/hasdelete', [CartItemController::class, 'hasDeleted'])->name('client.cart.hasdelete');
    Route::delete('/cart/{id}/force-delete', [CartItemController::class, 'forceDelete'])->name('client.cart.forceDelete');
    Route::patch('/cart/{id}/restore', [CartItemController::class, 'restore'])->name('client.cart.restore');
    Route::delete('/cart-items/force-delete-selected', [CartItemController::class, 'forceDeleteSelected'])->name('client.cart.forceDeleteSelected');
    Route::post('/cart-items/restore-selected', [CartItemController::class, 'restoreSelected'])->name('client.cart.restoreSelected');
    Route::get('/cart/bought', [CartItemController::class, 'bought'])->name('client.cart.bought');
    //mã giảm giá
    Route::post('/cart/apply-voucher', [ApplyVoucherController::class, 'applyVoucher'])->name('client.cart.applyVoucher');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'showCheckoutForm'])->name('checkout.form');
    Route::post('/checkout/process', [CheckoutController::class, 'processCheckout'])->name('checkout.process');
    Route::get('/checkout/success/{order:code}', [CheckoutController::class, 'success'])->name('checkout.success');
});

//thanh toán
Route::get('/vnpay-return', [CheckoutController::class, 'vnpayReturn'])->name('vnpay.return');
//Xuất file PDF
Route::get('/invoice/{order:code}/pdf', [App\Http\Controllers\InvoiceController::class, 'generatePDF'])->name('invoice.pdf');


// chat client
Route::post('/chat/send', [MessageController::class, 'send']);
Route::get('/chat/fetch', [MessageController::class, 'fetch']);



Route::middleware('auth')->group(function () {
    Route::get('/order-history', [ClientOrderController::class, 'orderHistory'])->name('order.history');
    Route::get('/order/{id}', [ClientOrderController::class, 'orderDetail'])->name('order.details');
    Route::put('/orders/{id}/cancel', [OrderController::class, 'cancel'])->name('order.cancel'); // Hủy đơn hàng
    Route::post('/orders/{id}/reorder', [ClientOrderController::class, 'reorder'])->name('order.reorder'); // Mua lại đơn hàng
    // Route::put('/orders/{id}/cancel', [ClientOrderController::class, 'cancel'])->name('order.cancel');
    Route::post('/orders/{order}/accept-return', [OrderController::class, 'acceptReturn'])->name('orders.acceptReturn');
});

// Nhấn vào tên sản phẩm ở giỏ hàng để chuyển sang trang chi tiết sản phẩm đấy
Route::get('/san-pham/{slug}', [ClientProductController::class, 'show'])->name('client.products.show');

// chat client
Route::post('/chat/send', [MessageController::class, 'send']);
Route::get('/chat/fetch', [MessageController::class, 'fetch']);


// Xem/Sửa hồ sơ cá nhân
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/change-password', [ChangePasswordController::class, 'showChangePasswordForm'])->name('profile.change-password.form');
    Route::post('/profile/update-password', [ChangePasswordController::class, 'changePassword'])->name('profile.update-password');
});

// Trang hot deal
use App\Http\Controllers\Client\HotDealController;

Route::get('/hot-deals', [HotDealController::class, 'index'])->name('hot-deals.index');


// Quản lý thống kê

// Thống kê sản phẩm theo danh mục
Route::get('/admin/thong-ke/san-pham', [ThongKeController::class, 'index'])->name('admin.thongke.index');
Route::get('/admin/thong-ke/data', [ThongKeController::class, 'getData'])->name('admin.thongke.data');

// Thống kê theo biến thể
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('thong-ke-bien-the', [\App\Http\Controllers\ThongKeBienTheController::class, 'index'])->name('admin.thongke.bienthe.index');
    Route::get('thong-ke-bien-the/data', [\App\Http\Controllers\ThongKeBienTheController::class, 'getData'])->name('admin.thongke.bienthe.data');
});

//end minigame
// Yêu cầu trả hàng Client
use App\Http\Controllers\Client\ReturnRequestController as ClientReturnRequestController;


Route::middleware(['auth'])->group(function () {
    Route::get('/return-requests', [ClientReturnRequestController::class, 'index'])->name('client.return-requests.index');
    Route::get('/return-requests/create/{orderId}', [ClientReturnRequestController::class, 'create'])->name('client.return-requests.create');
    Route::post('/return-requests/store', [ClientReturnRequestController::class, 'store'])->name('client.return-requests.store');
});

// Route bài viết theo danh mục

Route::get('/blog/danh-muc/{slug}', [ClientBlogController::class, 'showByCategory'])->name('client.blog-categories.show');

Route::get('/about', function () {
    return view('clients.about');
})->name('about');


// bình luận
Route::middleware('auth')->group(function () {
    Route::post('/comments', [ProductCommentController::class, 'store'])->name('comments.store');
});
Route::get('/comments/{productId}', [ProductCommentController::class, 'list'])->name('comments.list');

// Trạng thái đơn hàng client tự cập nhật không cần load lại trang
Route::get('/order/status/{id}', [\App\Http\Controllers\Client\ClientOrderController::class, 'getStatus'])->name('order.status'); 

// Trạng thái hoàn hàng client tự cập nhật không cần load lại trang
Route::get('/return-request/status/{id}', [\App\Http\Controllers\Client\ReturnRequestController::class, 'getStatus'])->name('return-request.status'); 
