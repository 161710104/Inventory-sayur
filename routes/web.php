<?php



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index');
Route::get('/coba', 'KaryawanController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//profile member
Route::get('settings/profile', 'SettingsController@profile');
Route::get('settings/profile/edit', 'SettingsController@editProfile');
Route::post('settings/profile', 'SettingsController@updateProfile');

//password setting member
Route::get('settings/password', 'SettingsController@editPassword');
Route::post('settings/password', 'SettingsController@updatePassword');

Route::group(['prefix'=>'admin', 'middleware'=>['auth','role:admin']], function () {
    Route::resource('users', 'UserController');

    Route::resource('barangs', 'BarangController');
    Route::get('barangs/getedit/{id}','BarangController@edit');
    Route::get('/barangs/delete/{id}','BarangController@delete');
    Route::post('barangs/edit/{id}','BarangController@update');
    Route::post('storebarangs','BarangController@store')->name('tambahbarang');
    Route::get('/barangs/downloadPDF/{view_type}','BarangController@downloadPDF');

    Route::resource('customers', 'CustomerController');
    Route::get('/customers/{id}/lihat','CustomerController@lihat');
    Route::get('/customers/{id}/beli_barang','CustomerController@redirect');
    Route::get('customers/getedit/{id}','CustomerController@edit');
    Route::get('/customers/delete/{id}','CustomerController@delete');
    Route::post('customers/edit/{id}','CustomerController@update');

    Route::resource('suppliers', 'SupplierController');
    
    Route::get('suppliers/getedit/{id}','SupplierController@edit');
    Route::post('suppliers/edit/{id}','SupplierController@update');
    Route::get('/suppliers/delete/{id}','SupplierController@delete');

    Route::resource('barang_masuks', 'BarangMasukController');
    Route::get('/barang_masuks/delete/{id}','BarangMasukController@delete');

    Route::resource('barang_keluars', 'BarangKeluarController');
    Route::get('/barang_keluars/delete/{id}','BarangKeluarController@delete');

    Route::resource('/akumulasi', 'LaporanPemasukanController');

    Route::resource('/laporan_pengeluaran', 'LaporanPengeluaranController');
    
});


Route::group(['prefix'=>'karyawan', 'middleware'=>['auth','role:karyawan|admin|superadmin']], function () {
    Route::resource('barang_masuks', 'BarangMasukController');
    Route::get('/barang_masuks/delete/{id}','BarangMasukController@delete');

    Route::resource('barang_keluars', 'BarangKeluarController');
     Route::get('/barang_keluars/delete/{id}','BarangKeluarController@delete');

    Route::resource('/akumulasi', 'LaporanPemasukanController');
   

    Route::resource('/laporan_pengeluaran', 'LaporanPengeluaranController');
    
    
});

//store
Route::post('storesuppliers','SupplierController@store')->name('tambah');
Route::post('storecustomers','CustomerController@store');
Route::post('storebarang_masuks','BarangMasukController@store')->name('tambahbarangmasuk');
Route::post('storebarang_keluars','BarangKeluarController@store');


//update

Route::get('barang_keluars/getedit/{id}','BarangKeluarController@edit');
Route::post('barang_keluars/edit/{id}','BarangKeluarController@update');
Route::get('barang_masuks/getedit/{id}','BarangMasukController@edit');
Route::post('barang_masuks/edit/{id}','BarangMasukController@update');

//laporan post
Route::post('/laporan_pemasukan' , 'LaporanPemasukanController@index2');
Route::post('/laporan_uang_keluar' , 'LaporanPengeluaranController@index2');

//ajax datatable
Route::get('/jsonuser','UserController@table');
Route::get('/jsonbarang','BarangController@table');
Route::get('/jsoncustomer','CustomerController@table');
Route::get('/jsonsupplier','SupplierController@table');
Route::get('/jsonbarang_masuks','BarangMasukController@table');
Route::get('/jsonbarang_keluars','BarangKeluarController@table');
Route::get('/jsonlaporan_pemasukan','LaporanPemasukanController@table');
Route::get('/jsonlaporan_pemasukan2','LaporanPemasukanController@table2');
Route::get('/jsonlaporan_pengeluaran','LaporanPengeluaranController@table');
//ajax lcg_value()
Route::get('/barangkeluars/getIdBarang','BarangKeluarController@getDetailBarang')->name('getIdBarang');
Route::get('/barang_keluars/getIdCustomer','BarangKeluarController@getDetailCustomer');
Route::get('/barang_masuks/getIdSupplier','BarangMasukController@getDetailSupplier');

//Print
Route::get('barangs/exportExcel',[
    'as'=> 'export.barang',
    'uses' => 'BarangController@downloadExcel'
]);
Route::get('laporan_pengeluarans/exportExcel',[
    'as'=> 'export.barang',
    'uses' => 'LaporanPengeluaranController@downloadExcel'
]);
Route::get('laporan_pemasukans/exportExcel',[
    'as'=> 'export.barang',
    'uses' => 'LaporanPemasukanController@downloadExcel'
]);
//print laporan pengeluaran
Route::get('/laporan_uang_keluar/downloadPDF/{view_type}','LaporanPengeluaranController@downloadPDF');
Route::get('/laporan_uang_keluar/downloadPDF2/{view_type}','LaporanPengeluaranController@downloadPDF2');

//print pdf laporan pemasukan
Route::get('/laporan_uang_masuk/downloadPDF/{view_type}','LaporanPemasukanController@downloadPDF');
Route::get('/laporan_uang_masuk2/downloadPDF/{view_type}','LaporanPemasukanController@downloadPDF2');


