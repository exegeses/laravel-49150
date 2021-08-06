<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/saludo', function ()
{
    return 'hola mundo desde Laravel';
});

Route::get('/saludo.html', function ()
{
    $nombre = 'marcos';
    $cenas = ['choripan', 'asado', 'milanesa con fritas', 'chaw fan'];

    return view('primera',
                    [
                        'nombre' => $nombre,
                        'cenas'  => $cenas
                    ]
            );
});

Route::get('/regiones', function ()
{
    //obtenemos listado de regiones
    $regiones = DB::select('SELECT regID, regNombre FROM regiones');
    return view('segunda', [ 'regiones'=>$regiones ]);
});

Route::get('/inicio', function ()
{
    return view('inicio');
});

###################################################
###### CRUD de regiones
Route::get('/adminRegiones', function ()
{
    $regiones = DB::select('SELECT regID, regNombre FROM regiones');
    return view('adminRegiones', [ 'regiones' => $regiones ]);
});
Route::get('/agregarRegion', function ()
{
    return view('agregarRegion');
});
Route::post('/agregarRegion', function ()
{
    //capturar dato enviado
    $regNombre = $_POST['regNombre'];
    //insertar en tabla regiones
    DB::insert('
                INSERT INTO regiones
                            ( regNombre )
                        VALUE
                            ( :regNombre )',
                            [ $regNombre ]
                );
    //redirección con mensaje ok (flashing)
    return redirect('/adminRegiones')
                ->with( [ 'mensaje'=>'Región: '.$regNombre.' agregada correctamente' ] );
});
Route::get('/modificarRegion/{id}', function ($id)
{
    //obtenemos una región por su ID
    /*
    $region = DB::select(
                    'SELECT regID, regNombre
                        FROM regiones
                        WHERE regID = :id',
                            [ $id ]
            );
    */
    $region = DB::table('regiones')
                    ->where('regID', $id)
                    ->first();
    return view('modificarRegion', [ 'region'=>$region ]);
});
Route::patch('/modificarRegion/', function ()
{
    $regID = $_POST['regID'];
    $regNombre = $_POST['regNombre'];
    //modificamos
    /*
    DB::update('
                UPDATE regiones
                    SET regNombre = :regNombre
                    WHERE regID = :regID',
                    [ $regNombre, $regID ]
            );
    */
    DB::table('regiones')
        ->where('regID', $regID)
        ->update( [ 'regNombre'=>$regNombre ] );
    //redirección con mensaje ok (flashing)
    return redirect('/adminRegiones')
        ->with( [ 'mensaje'=>'Región: '.$regNombre.' modificada correctamente' ] );
});

###################################################
###### CRUD de destinos
Route::get('/adminDestinos', function ()
{
    //obtenemos listado de destinos
    $destinos = DB::select('
                        SELECT
                            destID,
                            destNombre,
                            regNombre,
                            destPrecio,
                            destAsientos,
                            destDisponibles
                        FROM destinos as d
			            INNER JOIN regiones as r
                        ON d.regID = r.regID'
                );
    return view('adminDestinos', [ 'destinos'=>$destinos ]);
});
