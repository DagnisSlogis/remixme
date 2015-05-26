<?php
/**
 * Created by PhpStorm.
 * User: Dagnis
 * Date: 22.05.2015.
 * Time: 20:47
 */

class CompAcceptingTest extends TestCase{

    /**
     * Administrators izvēlās apskatīt apstiprinājumu gaidošos konkursus.
     */
    public function test_admin_sees_acceptable_comps()
    {
        $this->beAdmin();
        $this->visit('/adminpanel/comps/accept')
            ->onPage('/adminpanel/comps/accept');
    }

    /**
     * Administrators spiež “Apstiprināt”.
     */
    public function test_admin_accepts_comp()
    {
        $this->beUser();
        $user = \App\User::first();
        $this->Comp();
        $this->beAdmin();
        $comp = App\Comp::first();
        $this->visit('/adminpanel/comps/accept')
            ->press('Apstiprināt')
            ->see('Konkurss')
            ->onPage('/adminpanel/comps/accept');
        $this->verifyInDatabase('comps', ['title' => 'CompTitle' , 'status' => 'v']);
        $this->verifyInDatabase('notifications', ['comp_id' => $comp->id , 'user_id' => $user->id]);
    }

    /**
     * viesis nevar piekļūt šīm funkcijām.
     */
    public function test_guest_cant_access_accepting_page()
    {
        $this->visit('/adminpanel/comps/accept')
            ->onPage('auth/login');
    }

    /**
     * Lietotājs nevar piekļūt šīm funkcijām.
     */
    public function test_user_cant_access_accepting_page()
    {
        $this->beUser();
        $this->visit('/adminpanel/comps/accept')
            ->onPage('/');
    }
} 