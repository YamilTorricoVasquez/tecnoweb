<?php

use App\Http\Controllers\CaducidadController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DetalleCantidadVentaController;
use App\Http\Controllers\DetalleCompraController;
use App\Http\Controllers\DetalleVentaController;
use App\Http\Controllers\DevolucionController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\InventoryDetailController;
use App\Http\Controllers\NotaCompraController;
use App\Http\Controllers\NotaVentaController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ReasonController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VisitaController;
use App\Models\Category;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;





Route::get('/medicamentos', [ProductController::class, 'apiIndex']);
Route::post('/visitas', [VisitaController::class, 'incrementar']);
Route::get('/visitas', [VisitaController::class, 'obtener']);
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    $products = Product::count();
    $categories = Category::count();
    $suppliers = Supplier::count();
    $users = User::count();

    return Inertia::render('Dashboard', [
        'products' => $products,
        'categories' => $categories,
        'suppliers' => $suppliers,
        'users' => $users,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/products/check', [ProductController::class, 'check'])->name('products.check');
    Route::resource('products', ProductController::class);

    Route::resource('categories', CategoryController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('inventories', InventoryController::class);
    Route::resource('paymentmethods', PaymentMethodController::class);
    Route::resource('reasons', ReasonController::class);
    //  Route::resource('inventorydetails', InventoryDetailController::class);
    Route::resource('inventorydetails', InventoryDetailController::class)->parameters([
        'inventorydetails' => 'inventorydetail',
    ]);
    //Route::resource('devoluciones', DevolucionController::class);
    Route::resource('devoluciones', DevolucionController::class)->parameters([
        'devoluciones' => 'devolucion',
    ]);
    Route::resource('notacompras', NotaCompraController::class)->parameters([
        'notacompras' => 'notacompra',
    ]);
    Route::resource('notaventas', NotaVentaController::class)->parameters([
        'notaventas' => 'notaventa',
    ]);
    Route::resource('detalleventas', DetalleVentaController::class)->parameters([
        'detalleventas' => 'detalleventa',
    ]);

    Route::resource('detallecompras', DetalleCompraController::class)->parameters([
        'detallecompras' => 'detallecompra',
    ]);
    Route::resource('clientes', ClienteController::class)->parameters([
        'clientes' => 'cliente',
    ]);
    Route::resource('caducidades', CaducidadController::class)->parameters([
        'caducidades' => 'caducidad',
    ]);
    Route::resource('detallecantidadventas', DetalleCantidadVentaController::class)->parameters([
        'detallecantidadventas' => 'detallecantidadventa',
    ]);
    Route::post('/products/multiple', [ProductController::class, 'storeMultiple'])->name('products.storeMultiple');
    //Route::resource('register', RegisteredUserController::class);
  
    Route::post('/detallecompras/multiple', [\App\Http\Controllers\DetalleCompraController::class, 'storeMultiple'])->name('detallecompras.storeMultiple');
    Route::post('/detalleventas/multiple', [DetalleVentaController::class, 'storeMultiple'])->name('detalleventas.storeMultiple');
});

require __DIR__ . '/auth.php';
