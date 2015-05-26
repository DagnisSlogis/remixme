<?php
/**
 * Created by PhpStorm.
 * User: Dagnis
 * Date: 22.05.2015.
 * Time: 22:14
 */
use Laracasts\TestDummy\Factory as TestDummy;
class SubmitionRegistrationTest extends TestCase{

    /**
     * Obligātie lauki tiek atstāti neizpildīti.
     */
    public function test_adding_song_to_comp_form_empty()
    {
        $this->TestComp();
        $this->beUser();
        $this->visit('/')
            ->type('','title')
            ->type('','link')
            ->press('Iesūtit')
            ->see('title lauks');
    }

    /**
     * Tiek ievadīta “Soundcloud adrese”
     */
    public function test_sc_link_entered_player_showed()
    {
        $this->TestComp();
        $this->beUser();
        $this->visit('/')
            ->type('','title')
            ->type('dadad','link')
            ->see('iframe');
    }

    /**
     * Tiek ievadīti korekti dati, tiek uzspiesta poga “Iesūtīt”. Konkursam lietotājs nav pievienojis dziesmu.
     */
    public function test_first_entry_at_comp()
    {
        $comp = $this->TestComp();
        $this->VotingForAComp($comp);
        $this->beUser();
        $this->visit('/')
            ->type('Testa dziesma','title')
            ->type('dadad','link')
            ->press('Iesūtit')
            ->see('pievienota');
        $this->verifyInDatabase('submitions', ['title' => 'Testa dziesma' , 'status' => 'v']);
        $this->verifyInDatabase('notifications', ['comp_id' => $comp->id , 'type' => 'CompEnded']);
        $this->verifyInDatabase('notifications', ['comp_id' => $comp->id , 'type' => 'SubmitionEnded']);
        return $comp;
    }

    /**
     * Tiek ievadīti korekti dati, tiek uzspiesta poga “Iesūtīt”. Konkursam lietotājs ir jau pievienojis dziesmu.
     */
    public function test_already_entered_at_this_comp()
    {
        $comp = $this->test_first_entry_at_comp();
        $this->visit('/')
            ->type('otra dziesma','title')
            ->type('otrā','link')
            ->press('Iesūtit')
            ->see('pievienota');
        $this->verifyInDatabase('submitions', ['title' => 'Testa dziesma' , 'status' => 'b']);
        $this->verifyInDatabase('submitions', ['title' => 'otra dziesma' , 'status' => 'v']);
        $this->verifyInDatabase('notifications', ['comp_id' => $comp->id , 'type' => 'CompEnded']);
        $this->verifyInDatabase('notifications', ['comp_id' => $comp->id , 'type' => 'SubmitionEnded']);
    }

    /**
     * Viesis mēģina pievienot dziesmu konkursam.
     */
    public function test_guest_tries_to_enter_his_song()
    {
        $this->TestComp();
        $this->visit('/')
            ->type('otra dziesma','title')
            ->type('otrā','link')
            ->press('Iesūtit')
            ->onPage('auth/login');
    }
} 