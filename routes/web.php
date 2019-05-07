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

#Route::get('/', function () {
#    return view('welcome');
#});

Route::get('/', function () {
    return view('index');
});

Route::get('/directory/{path_file?}', 'LogController@storage')->name('storage');
Route::post('/openImage', 'LogController@openImage')->name('openImgae');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('index');
Route::get('/ruang', 'RuangController@index')->name('ruang');
Route::get('/ruang/create', 'RuangController@create')->name('ruang.add');
Route::post('/ruang/store', 'RuangController@store');
Route::get('/ruang/{idRuang}/edit', 'RuangController@edit');
Route::post('/ruang/{idRuang}', 'RuangController@update');
Route::get('/ruang/delete/{idRuang}', 'RuangController@destroy');

Route::get('/pic', 'PicController@index')->name('pic');
Route::get('/pic/create', 'PicController@create')->name('pic.add');
Route::post('/pic/store', 'PicController@store');
Route::get('/pic/{idPIC}/edit', 'PicController@edit');
Route::post('/pic/{idPIC}', 'PicController@update');
Route::get('/pic/delete/{idPIC}', 'PicController@destroy');

Route::get('/agenda', 'AgendaController@index')->name('agenda');
Route::get('/agenda/create', 'AgendaController@create')->name('agenda.add');
Route::post('/agenda/store', 'AgendaController@store');
Route::get('/agenda/edit/{idAgenda}', 'AgendaController@edit')->name('agenda.edit');
Route::post('/agenda{idAgenda}', 'AgendaController@update');
Route::get('/agenda/delete/{idAgenda}', 'AgendaController@destroy');
Route::get('/agenda/{idAgenda}/qrCode', 'AgendaController@qrCode');



Route::get('/log', 'LogController@index')->name('log');
Route::get('/log/create', 'LogController@create')->name('log.add');
Route::post('/log/store', 'LogController@store');
Route::get('/log/{idLog}/edit', 'LogController@edit');
Route::post('/log/{idLog}', 'LogController@update');
Route::get('/log/delete/{idLog}', 'LogController@destroy');

Route::get('/absenKuliah', 'AbsenKuliahController@index')->name('absenKuliah');
Route::get('/absenKuliah/create', 'AbsenKuliahController@create')->name('absenKuliah.add');
Route::post('/absenKuliah/statuskehadiran', 'AbsenKuliahController@UpdateStatusKehadiran')->name('absenKuliah.UpdateStatusKehadiran');
Route::post('/absenKuliah/toleransikehadiran', 'AbsenKuliahController@UpdateToleransiKehadiran')->name('absenKuliah.UpdateToleransiKehadiran');
//azzam jiul
Route::get('/absenKuliah/berita/{idAgenda}', 'AbsenKuliahController@berita')->name('absenKuliah.berita');
Route::get('/absenKuliah/{idAgenda}', 'AbsenKuliahController@tampilKehadiran')->name('absenKuliah.tampilKehadiran');
//end
Route::post('/absenKuliah/store', 'AbsenKuliahController@store');
Route::get('/absenKuliah/{idAbsen}/edit', 'AbsenKuliahController@edit')->name('absenKuliah.edit');
Route::post('/absenKuliah/{idAbsen}', 'AbsenKuliahController@update')->name('absenKuliah.update');
Route::get('/absenKuliah/delete/{idAbsen}', 'AbsenKuliahController@destroy');
//-----------------------------------------------------------------------------------

//-----------Agenda by PIC
Route::get('/myagenda', 'AgendaByPICController@index')->name('AgendaByPIC');
Route::get('/myagenda/create', 'AgendaByPICController@create')->name('AgendaByPIC.add');
Route::post('/myagenda/statuskehadiran', 'AgendaByPICController@UpdateStatusKehadiran')->name('AgendaByPIC.UpdateStatusKehadiran');
Route::post('/myagenda/toleransikehadiran', 'AgendaByPICController@UpdateToleransiKehadiran')->name('AgendaByPIC.UpdateToleransiKehadiran');
//-----------Agenda by PIC-->berita
Route::get('/myagenda/berita/{idAgenda}', 'AgendaByPICController@berita')->name('AgendaByPIC.berita');
Route::get('/myagenda/{idAgenda}', 'AgendaByPICController@tampilKehadiran')->name('AgendaByPIC.tampilKehadiran');
Route::get('/myagenda/penilaian/{idAgenda}', 'AgendaByPICController@tampilNilai')->name('AgendaByPIC.tampilNilai');
//-----------Agenda by PIC
Route::post('/myagenda/store', 'AgendaByPICController@store');
Route::get('/myagenda/{idAbsen}/edit', 'AgendaByPICController@edit')->name('AgendaByPIC.edit');
Route::post('/myagenda/{idAbsen}', 'AgendaByPICController@update')->name('AgendaByPIC.update');
Route::post('/myagenda/tambahpenilaian', 'AgendaByPICController@berita')->name('AgendaByPIC.tambahpenilaian');
Route::get('/myagenda/delete/{idAbsen}', 'AgendaByPICController@destroy');


Route::resource('download','DownloadController');



// Download Route
Route::get('downloadAPK/{filename}', function($filename)
{
    // Check if file exists in app/storage/file folder
    $file_path = storage_path() .'/file/'. $filename;
    if (file_exists($file_path))
    {
        // Send Download
        return Response::download($file_path, $filename, [
            'Content-Length: '. filesize($file_path)
        ]);
    }
    else
    {
        // Error
        exit('Requested file does not exist on our server!');
    }
})
->where('filename', '[A-Za-z0-9\-\_\.]+');
