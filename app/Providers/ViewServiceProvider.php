<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
        $this->composeSubmenu();
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

    private  function composeSubmenu(){
        view()->composer('adminpanel.comps.layout.submenu' , 'App\Http\Composers\SubmenuComposer@comppanel');
    }


}
