<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomeController,
    PropertyController,
    AgencyController,
    UserController,
    AdminController,
    Auth\AuthController,
    Auth\RegisterController,
    ImageController,
    Auth\ChooseAccountController,
    MessageController,
    LocaleController,
    PaymentController
};

// ========================
// تغيير اللغة
// ========================
Route::get('/locale/{locale}', [LocaleController::class, 'setLocale'])->name('locale.set');

// ========================
// الصفحة الرئيسية
// ========================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('properties.search');
Route::get('/advanced-search', [HomeController::class, 'advancedSearch'])->name('properties.advanced-search');

// ========================
// المصادقة (لغير المسجلين)
// ========================
Route::middleware('guest')->group(function () {

    // تسجيل الدخول
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // اختيار نوع الحساب
    Route::get('/choose-account', [ChooseAccountController::class, 'index'])->name('choose.account');

    // تسجيل حساب فردي
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    // تسجيل حساب وكالة
    Route::get('/register/agency', [RegisterController::class, 'showAgencyRegistrationForm'])->name('register.agency.form');
    Route::post('/register/agency', [RegisterController::class, 'registerAgency'])->name('register.agency');
});

// تسجيل الخروج
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ========================
// العقارات (عرض عام)
// ========================
Route::get('/property', function () {
    return redirect()->route('properties.index');
});
Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
Route::get('/properties/{id}', [PropertyController::class, 'show'])->name('properties.show');

// ========================
// الوكالات (عرض عام)
// ========================
Route::get('/agencies', [AgencyController::class, 'index'])->name('agencies.index');
Route::get('/agencies/{id}', [AgencyController::class, 'show'])->name('agencies.show');

// ========================
// إرسال الرسائل (للزوار والمستخدمين المسجلين)
// ========================
Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');

// ========================
// المدفوعات (للتطوير - بدون مصادقة)
// ========================
Route::prefix('payment')->group(function () {
    Route::match(['get', 'post'], '/success/{paymentId}', [PaymentController::class, 'simulateSuccess'])->name('payment.success');
});

// ========================
// مسارات تتطلب تسجيل الدخول
// ========================
Route::middleware(['auth'])->group(function () {

    // ------------------------
    // المستخدم
    // ------------------------
    Route::prefix('user')->group(function () {
        Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
        Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('user.profile.edit');
        Route::put('/profile', [UserController::class, 'updateProfile'])->name('user.profile.update');
        
        // الإعدادات
        Route::get('/settings', [UserController::class, 'settings'])->name('user.settings');
        Route::put('/settings', [UserController::class, 'updateSettings'])->name('user.settings.update');
        
        Route::get('/properties', [UserController::class, 'properties'])->name('user.properties');
        Route::get('/favorites', [UserController::class, 'favorites'])->name('user.favorites');
        Route::post('/favorites/{id}', [UserController::class, 'addToFavorites'])->name('user.favorites.add');
        Route::delete('/favorites/{id}', [UserController::class, 'removeFromFavorites'])->name('user.favorites.remove');
    });

    // ------------------------
    // الرسائل (باستخدام MessageController)
    // ------------------------
    // Route::prefix('messages')->group(function () {
    //     Route::get('/', [MessageController::class, 'index'])->name('users.messages.index');
    //     Route::post('/', [MessageController::class, 'store'])->name('messages.store');
    //     Route::get('/{id}', [MessageController::class, 'show'])->name('messages.show');
    //     Route::delete('/{id}', [MessageController::class, 'destroy'])->name('messages.destroy');
    // });


    Route::get('/messages', [MessageController::class, 'index'])->middleware('auth')->name('users.message.index');

    // ------------------------
    // إدارة العقارات
    // ------------------------
    Route::get('/property/create', [PropertyController::class, 'create'])->name('properties.create');
    Route::post('/property', [PropertyController::class, 'store'])->name('properties.store');
    Route::get('/property/{id}/edit', [PropertyController::class, 'edit'])->name('properties.edit');
    Route::put('/property/{id}', [PropertyController::class, 'update'])->name('properties.update');
    Route::delete('/property/{id}', [PropertyController::class, 'destroy'])->name('properties.destroy');
    Route::post('/property/{id}/contact', [PropertyController::class, 'contact'])->name('properties.contact');
    Route::post('/property/{id}/favorite', [PropertyController::class, 'toggleFavorite'])->name('properties.favorite');

    // ------------------------
    // المدفوعات
    // ------------------------
    Route::prefix('payment')->group(function () {
        Route::get('/packages/{bienId}', [PaymentController::class, 'showPublicationPackages'])->name('payment.packages');
        Route::post('/create/{bienId}', [PaymentController::class, 'createPayment'])->name('payment.create');
        Route::get('/process/{paymentId}', [PaymentController::class, 'processPayment'])->name('payment.process');
        Route::match(['get', 'post'], '/success/{paymentId}', [PaymentController::class, 'simulateSuccess'])->name('payment.success');
        Route::get('/failure/{paymentId}', [PaymentController::class, 'simulateFailure'])->name('payment.failure');
        Route::get('/history', [PaymentController::class, 'paymentHistory'])->name('payment.history');
    });

    // ------------------------
    // لوحة تحكم الوكالات
    // ------------------------
    Route::prefix('agency')->group(function () {
        Route::get('/dashboard', [AgencyController::class, 'dashboard'])->name('agencies.dashboard');
        Route::post('/{id}/contact', [AgencyController::class, 'contact'])->name('agencies.contact');
        Route::put('/profile', [AgencyController::class, 'updateProfile'])->name('agencies.profile.update');
    });

    // ------------------------
    // إدارة الصور
    // ------------------------
    Route::prefix('images')->group(function () {
        Route::delete('/{id}', [ImageController::class, 'destroy'])->name('images.destroy');
        Route::post('/{id}/set-main', [ImageController::class, 'setAsMain'])->name('images.set-main');
        Route::post('/{bienId}/upload', [ImageController::class, 'store'])->name('images.upload');
        Route::post('/{bienId}/reorder', [ImageController::class, 'reorder'])->name('images.reorder');
        Route::get('/{bienId}/bien-images', [ImageController::class, 'getBienImages'])->name('images.bien-images');
        Route::post('/cleanup', [ImageController::class, 'cleanupOrphanedImages'])->name('images.cleanup');
    });

    // ------------------------
    // الإدارة (Admin)
    // ------------------------
    Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        // إدارة العقارات
        Route::get('/properties', [AdminController::class, 'properties'])->name('admin.properties');
        Route::post('/properties/{id}/approve', [AdminController::class, 'approveProperty'])->name('admin.properties.approve');
        Route::post('/properties/{id}/reject', [AdminController::class, 'rejectProperty'])->name('admin.properties.reject');
        Route::post('/properties/{id}/feature', [AdminController::class, 'featureProperty'])->name('admin.properties.feature');
        Route::post('/properties/{id}/unfeature', [AdminController::class, 'unfeatureProperty'])->name('admin.properties.unfeature');

        // إدارة المستخدمين
        Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
        Route::put('/users/{id}/role', [AdminController::class, 'updateUserRole'])->name('admin.users.role');

        // إدارة الوكالات
        Route::get('/agencies', [AdminController::class, 'agencies'])->name('admin.agencies');

        // التقارير والإعدادات
        Route::get('/reports', [AdminController::class, 'reports'])->name('admin.reports');
        Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
    });
});


// Routes for user messages
Route::prefix('users')->name('users.')->group(function () {
    Route::prefix('messages')->name('messages.')->group(function () {
        Route::get('/', [MessageController::class, 'index'])->name('index'); // قائمة الرسائل
        Route::get('/create', [MessageController::class, 'create'])->name('create'); // إنشاء رسالة جديدة
        Route::post('/', [MessageController::class, 'store'])->name('store'); // حفظ الرسالة
        Route::get('/{id}/edit', [MessageController::class, 'edit'])->name('edit'); // تعديل الرسالة
        Route::put('/{id}', [MessageController::class, 'update'])->name('update'); // تحديث الرسالة
        Route::delete('/{id}', [MessageController::class, 'destroy'])->name('destroy'); // حذف الرسالة
        Route::get('/{id}', [MessageController::class, 'show'])->name('show'); // عرض رسالة مفردة
    });
});


// ========================
// صفحات ثابتة
// ========================
Route::get('/terms', fn() => view('pages.terms'))->name('terms');
Route::get('/privacy', fn() => view('pages.privacy'))->name('privacy');

// pour les langues
Route::get('change-lang/{lang}', function ($lang) {
    session(['locale' => $lang]);
    app()->setLocale($lang);
    return back();
});



