<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class GateServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $folder = base_path('app/Permissions/Gates');
        
        if (is_dir($folder)) {
            $files = scandir($folder);
            
            foreach ($files as $file) {
                if (is_file("$folder/$file") && pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                    require_once "$folder/$file";
                }
            }
        }
        
        //require base_path('app/Permissions/Gates/admin-gates.php');
    }
}
