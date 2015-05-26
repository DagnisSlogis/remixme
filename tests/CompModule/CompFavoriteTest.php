<?php
/**
 * Created by PhpStorm.
 * User: Dagnis
 * Date: 22.05.2015.
 * Time: 20:57
 */
use App\User;
use Laracasts\TestDummy\Factory as TestDummy;
class CompFavoriteTest extends TestCase {

    /**
     * Izvēlās pievienot konkursu favorītiem spiežot sirsniņu pie konkursa.
     */
    public function test_user_adds_comp_to_favorites()
    {
        $this->beUser();
        $comp = $this->TestComp();
        $user = User::first();
        $this->visit('/')
            ->press('Favorītot')
            ->see('Konkurss')
            ->onPage('/');
        $this->verifyInDatabase('favorites', ['user_id' => $user->id , 'comp_id' => $comp->id]);
        $this->verifyInDatabase('notifications', ['user_id' => $user->id , 'comp_id' => $comp->id , 'type' => 'SubmitionEnded']);
        $this->verifyInDatabase('notifications', ['user_id' => $user->id , 'comp_id' => $comp->id , 'type' => 'CompEnded']);
        $this->verifyInDatabase('notifications', ['user_id' => $comp->user_id , 'comp_id' => $comp->id]);
        return $comp;
    }

    /**
     * Izvēlās pievienot konkursu favorītiem, kurš jau ir pievienots šī lietotāja favorītiem.
     */
    public function test_user_adds_comp_to_fav_but_it_already_is_there()
    {
        $this->test_user_adds_comp_to_favorites();
        $this->visit('/')
            ->press('Favorītot')
            ->see('Kļūda')
            ->onPage('/');
    }

    /**
     * Tiek apskatīti visi lietotāja favorīt konkursi.
     */
    public function test_user_sees_his_favorite_list()
    {
        $comp = $this->test_user_adds_comp_to_favorites();
        $this->visit('userpanel/favorite')
            ->see($comp->title)
            ->onPage('userpanel/favorite');
    }

    /**
     * Tiek spiests “Dzēst” uz kāda favorīta.
     */
    public function test_user_deletes_his_favorite()
    {
        $this->beUser();
        $comp = $this->TestComp();
        $user = User::first();
        $this->visit('/')
            ->press('Favorītot')
            ->see('Konkurss')
            ->onPage('/');
        $this->visit('userpanel/favorite')
            ->onPage('userpanel/favorite')
            ->press('Dzēst')
            ->see('Nav neviena')
            ->onPage('userpanel/favorite');
        if(!$this->verifyInDatabase('favorites', ['user_id' => $user->id , 'comp_id' => $comp->id]) &&
        !$this->verifyInDatabase('notifications', ['user_id' => $user->id , 'comp_id' => $comp->id , 'type' => 'SubmitionEnded']) &&
        !$this->verifyInDatabase('notifications', ['user_id' => $user->id , 'comp_id' => $comp->id , 'type' => 'CompEnded']))
        {
            $this->assertTrue(true);
        }
    }

    /**
     * Viesis mēģina izpildīt kādu no minētajām darbībām.
     */
    public function test_guest_tries_to_see_favorite_page()
    {
        $this->visit('userpanel/favorite')
            ->onPage('auth/login');
    }

} 