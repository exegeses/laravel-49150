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
Route::get('/eliminarRegion/{id}', function ($id)
{
    $region = DB::table('regiones')
                ->where('regID', $id)
                ->first();
    return view('eliminarRegion', [ 'region'=>$region ]);
});
Route::delete('/eliminarRegion', function ()
{
    $regID = $_POST['regID'];
    $regNombre = $_POST['regNombre'];
    /* DB::delete('DELETE FROM regiones
                    WHERE regID = :regID', [ $regID ]); */
    DB::table('regiones')
            ->where('regID', $regID)
            ->delete();
    return redirect('/adminRegiones')
        ->with( [ 'mensaje'=>'Región: '.$regNombre.' eliminada correctamente' ] );
});

###################################################
###### CRUD de destinos
Route::get('/adminDestinos', function ()
{
    //obtenemos listado de destinos
    /*
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
    */
    $destinos = DB::table('destinos as d')
                        ->join('regiones as r', 'd.regID', '=', 'r.regID' )
                        ->select('destID','destNombre', 'regNombre',
                                  'destPrecio', 'destAsientos', 'destDisponibles')
                        ->get();

    return view('adminDestinos', [ 'destinos'=>$destinos ]);
});
Route::get('/agregarDestino', function ()
{
    $regiones = DB::table('regiones')->get();
    return view('agregarDestino', [ 'regiones'=>$regiones ]);
});
Route::post('/agregarDestino', function ()
{
    //capturamos datos enviados por el form
    $destNombre = $_POST['destNombre'];
    $regID = $_POST['regID'];
    $destPrecio = $_POST['destPrecio'];
    $destAsientos = $_POST['destAsientos'];
    $destDisponibles = $_POST['destDisponibles'];
    //insertarmos
    /*DB::insert(
                'INSERT INTO destinos
                    ( destNombre, regID, destPrecio, destAsientos, destDisponibles )
                   VALUE
                    ( :destNombre, :regID, :destPrecio, :destAsientos, :destDisponibles )',
                    [ $destNombre, $regID, $destPrecio, $destAsientos, $destDisponibles ]
        );*/
    DB::table('destinos')
            ->insert(
                [
                    'destNombre'    =>  $destNombre,
                    'regID'         =>  $regID,
                    'destPrecio'    =>  $destPrecio,
                    'destAsientos'  =>  $destAsientos,
                    'destDisponibles'=> $destDisponibles
                ]
            );
    return redirect('/adminDestinos')
        ->with( [ 'mensaje'=>'Destino: '.$destNombre.' agregado correctamente' ] );
});
Route::get('/modificarDestino/{id}', function ($id)
{
    //obtenemos datos de un destino por su id
    $destino = DB::table('destinos')
                    ->where('destID', $id)->first();
    //obtenemos listado de las regiones
    $regiones = DB::table('regiones')->get();
    //retornamos vista pasando los datos
    return view('modificarDestino',
                    [
                        'destino'=>$destino,
                        'regiones'=>$regiones
                    ]
            );
});
Route::patch('/modificarDestino', function ()
{
    //capturamos datos enviados por el form
    $destNombre = $_POST['destNombre'];
    $regID = $_POST['regID'];
    $destPrecio = $_POST['destPrecio'];
    $destAsientos = $_POST['destAsientos'];
    $destDisponibles = $_POST['destDisponibles'];
    $destID = $_POST['destID'];
    //modificamos
    DB::table('destinos')
            ->where('destID', $destID)
            ->update(
                [
                    'destNombre'=>$destNombre,
                    'regID'=>$regID,
                    'destPrecio'=>$destPrecio,
                    'destAsientos'=>$destAsientos,
                    'destDisponibles'=>$destDisponibles
                ]
            );
    return redirect('/adminDestinos')
        ->with( [ 'mensaje'=>'Destino: '.$destNombre.' modificado correctamente' ] );
});
