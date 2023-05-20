<?php 



//create storage link
Route::get('/storage-link', function () {   
    /*
    $folders = ['courses','subjects','users111'];
    foreach ($folders as $folderName) {        
        $folderPath = $storagePath = storage_path('app/public/'.$folderName);
        
        if (!is_dir($folderPath)) {
            mkdir($folderPath, 0777, true);
            dump($folderPath." folder created successfully.");
        } else {
            dump($folderPath." folder already exists.");
        }
    } 
    */
    Artisan::call('storage:link');
    return; 
});



/***** clear cache commands ****/
//Clear Cache facade value:
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});

//Reoptimized class loader:
Route::get('/optimize', function() {
    $exitCode = Artisan::call('optimize');
    return '<h1>Reoptimized class loader</h1>';
});

//Route cache: 
Route::get('/route-cache', function() {
    $exitCode = Artisan::call('route:cache');
    return '<h1>Routes cached</h1>';
});

//Clear Route cache:
Route::get('/route-clear', function() {
    $exitCode = Artisan::call('route:clear');
    return '<h1>Route cache cleared</h1>';
});

//Clear View cache:
Route::get('/view-clear', function() {
    $exitCode = Artisan::call('view:clear');
    return '<h1>View cache cleared</h1>';
});

//Clear Config cache:
Route::get('/config-cache', function() {
    $exitCode = Artisan::call('config:cache');
    return '<h1>Clear Config cleared</h1>';
});

