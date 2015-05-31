<?php
use Laracasts\TestDummy\Factory;

/**
 * Created by PhpStorm.
 * User: Dagnis
 * Date: 22.05.2015.
 * Time: 19:21
 */

class CompManagmentTest extends TestCase {


    /**
     * Lietotājs izvēlās apskatīties savus konkursus
     */
    public function test_user_wants_to_see_his_comps()
    {
        $this->beUser();
        $this->Comp();
        $this->visit('userpanel/comps')
            ->see('CompTitle')
            ->onPage('userpanel/comps');
    }

    /**
     * Administrators izvēlās apskatīties visus konkursus sistēmā.
     */
    public function test_admin_wants_to_see_all_comps()
    {
        $this->beAdmin();
        $comp = $this->TestComp();
        $this->visit('/adminpanel/comps')
            ->see($comp->title)
            ->onPage('/adminpanel/comps');
    }

    /**
     * Izvēlās dzēst konkursu no saraksta spiežot pogu “Dzēst”.
     */
    public function test_selects_a_comp_to_delete()
    {
        $user = $this->DummyUser();
        $comp = $this->CompForUser($user);
        $this->VotingForAComp($comp);
        $this->be($user);
        $this->visit('userpanel/comps')
            ->press('Dzēst')
            ->see('dzēsts')
            ->onPage('userpanel/comps');
        $this->verifyInDatabase('comps', ['title' => $comp->title , 'status' => 'b']);
        $this->verifyInDatabase('votings', ['comp_id' => $comp->id , 'status' => 'b']);
    }

    /**
     * Izvēlās labot konkursu spiežot pogu “Labot”
     */
    public function test_selects_a_comp_to_change()
    {
        $this->beUser();
        $this->Comp();
        $this->visit('userpanel/comps')
            ->click('Labot')
            ->see('Labot konkursu');
    }

    /**
     * Lietotājs mēģina pārvaldīt cita lietotāja konkursu.
     */
    public function test_user_tries_to_change_other_users_comp()
    {
        $comp = $this->TestComp();
        $this->beUser();
        $this->Comp();
        $this->visit('comp/'.$comp->id.'/edit')
            ->see('Kļūda');
    }

    /**
     * Viesis mēģina piekļūt pārvaldīšanas funkcijām.
     */
    public function test_guest_tries_to_use_comp_managment_functions()
    {
        $comp = $this->TestComp();
        $this->visit('comp/'.$comp->id.'/edit')
            ->onPage('auth/login');
        $this->visit('userpanel/comps')
            ->onPage('auth/login');
        $this->visit('/adminpanel/comps')
            ->onPage('auth/login');
    }
} 