<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider {

	/**
	 * Ielādē skata daļas
	 *
	 * @return void
	 */
	public function boot()
	{
        $this->composeSubmenu();
        $this->composeProfileNav();
        $this->composeUserNotif();
        $this->composeCompSubmenu();
        $this->composeSidebar();
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

    /**
     * Izveido lietotājpaneļa submenu
     */
    private function composeCompSubmenu()
    {
        view()->composer('userpanel.comps.layout.submenu' , 'App\Http\Composers\CompSubmenuComposer@main');
    }

    /**
     * Izveido sidebāru
     */
    private function composeSidebar()
    {
        view()->composer('layout.sidebar' , 'App\Http\Composers\SideBarComposer@main');
    }
}
