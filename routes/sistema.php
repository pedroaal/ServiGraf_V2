<?php
Route::namespace('Sistema')
->middleware('hasModRol:80,1')
->group(function () {
  Route::get('/horarios', 'Horarios@show')->name('horarios')->middleware('hasModRol:80,1');
  Route::post('/horario/store', 'Horarios@store')->name('horario.store')->middleware('hasModRol:80,2');
  Route::put('/horario/update/{horario}', 'Horarios@update')->name('horario.update')->middleware('hasModRol:80,3');

  Route::get('/empresa', 'Empresa@show')->name('empresa')->middleware('hasModRol:81,1');
  Route::post('/empresa/store', 'Empresa@store')->name('empresa.store')->middleware('hasModRol:81,2');
  Route::put('/empresa/update/{empresa}', 'Empresa@update')->name('empresa.update')->middleware('hasModRol:81,3');

  Route::post('/factura/store', 'Empresa@storeFact')->name('factura.store')->middleware('hasModRol:81,2');
  Route::put('/factura/update/{factura}', 'Empresa@updateFact')->name('factura.update')->middleware('hasModRol:81,3');
  
  Route::post('/claves', 'Claves@show')->name('claves')->middleware('hasModRol:81,1')->middleware('password.confirm');
  Route::post('/clave/store', 'Claves@store')->name('clave.store')->middleware('hasModRol:81,2');
  Route::put('/clave/update/{clave}', 'Claves@update')->name('clave.update')->middleware('hasModRol:81,3');
  Route::delete('/clave/delete/{clave}', 'Claves@delete')->name('clave.delete')->middleware('hasModRol:81,4');
});