<?php
use Illuminate\Support\Facades\Route;

Route::get('/', \App\Livewire\HomePage::class)->name('home');
Route::get('/menu', \App\Livewire\MenuPage::class)->name('menu');
Route::get('/recensies', \App\Livewire\RecentiesPage::class);
Route::get('/plattegrond', \App\Livewire\PlattegrondPage::class)->name('noFooter.plattegrond');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/admin/reservations', \App\Livewire\ReservationPage::class)->middleware('role:medewerker')->name('noFooter.reservations');
    Route::get('/admin/tables', \App\Livewire\TablePage::class)->middleware('role:medewerker|admin')->name('noFooter.tables');
    Route::get('/admin/users', \App\Livewire\UsersPage::class)->middleware('role:admin')->name('noFooter.users');
    Route::get('/admin/reservation/{reservation}', \App\Livewire\TableOrderPage::class)->middleware('role:medewerker')->name('noFooter.reservation');
    Route::get('/admin/order', \App\Livewire\OrderPage::class)->middleware('role:medewerker')->name('noFooter.order');
    Route::get('/admin/table-view', \App\Livewire\ReservedTableViewPage::class)->middleware('role:medewerker')->name('noFooter.table-view');
    Route::get('/recensies/toevoegen', \App\Livewire\RecentiesToevoegPage::class)->name('recenties.toevoegen');
    Route::get('/recensies/bijwerken/{id}', \App\Livewire\RecentiesToevoegPage::class)->name('recenties.bijwerken');
    Route::get('/bill/{bill}', \App\Livewire\BillDetailPage::class)->name('bill.detail');
    Route::get("/admin/recensies",\App\Livewire\AdminRecenties::class)->middleware('role:admin');
    Route::get('/profile', \App\Livewire\ProfilePage::class)->name('profile')->name('noFooter.profile');
    Route::get('/admin/kitchen-manager', \App\Livewire\KitchenManager::class)->name('noFooter.kitchen-manager');
    Route::get('/admin/bills', \App\Livewire\BillOverviewPage::class)->name('admin.bill-overview');
    Route::get("/admin/recensies", \App\Livewire\AdminRecenties::class)->middleware('role:admin')->name('noFooter.admin-recenties');
});

