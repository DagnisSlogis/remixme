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
        $this->composeProfileNav();
        $this->composeUserNotif();
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

    /**
     * Kad tiek izveidota lapa, tiek izveidots submenu skats.
     */
    private function composeSubmenu(){
        view()->composer('adminpanel.comps.layout.submenu' , 'App\Http\Composers\SubmenuComposer@comppanel');
    }

    /**
     * Kad tiek izveidota lapa, tiek izveidota profila navigācija
     */
    private function composeProfileNav()
    {
        view()->composer('layout.profile_nav' , 'App\Http\Composers\ProfileNavComposer@main');
    }

    private function composeUserNotif()
    {
        view()->composer('layout.popups.notification' , 'App\Http\Composers\NotificationComposer@main');
    }
}
