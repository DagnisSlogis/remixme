<?php
use App\User;

/**
 * Created by PhpStorm.
 * User: Dagnis
 * Date: 22.05.2015.
 * Time: 22:42
 */
use Laracasts\TestDummy\Factory;
class SubmitionManagmentTest extends TestCase{

    /**
     * Lietotājs izvēlās apskatīties savas iesūtītās dziesmas
     */
    public function test_user_wants_to_see_his_songs()
    {
        $comp = $this->TestComp();
        $this->VotingForAComp($comp);
        $this->beUser();
        $this->visit('/')
            ->type('Testa dziesma','title')
            ->type('dadad','link')
            ->press('Iesūtit');
        $this->visit('/userpanel/mysongs')
            ->see('Testa dziesma')
            ->onPage('/userpanel/mysongs');
    }

    /**
     * Administrators izvēlās apskatīties kāda konkursa iesūtītas dziesmas.
     */
    public function test_admin_wants_to_see_comps_entrys()
    {
        $comp = $this->TestComp();
        $voting = $this->VotingForAComp($comp);
        $this->SongsForAComp($voting);
        $this->beAdmin();
        $this->visit('adminpanel/comps')
            ->click('dziesmas')
            ->see('remiksi');
    }

    /**
     * Konkursa rīkotājs izvēlās apskatīties sava konkursa iesūtītās dziesmas.
     */
    public function test_user_wants_to_see_his_comp_entries()
    {
        $user = $this->DummyUser();
        $comp = $this->CompForUser($user);
        $voting = $this->VotingForAComp($comp);
        $song = $this->SongsForAComp($voting);
        $this->be($user);
        $this->visit('comp/submitions/'.$comp->id)
            ->see($song->title)
            ->onPage('comp/submitions/'.$comp->id);
    }

    /**
     * Lietotājs mēģina apskatīties cita lietotāja konkursam pievienotās dziesmas.
     */
    public function test_user_wants_to_see_other_user_comp_entries()
    {
        $user = $this->DummyUser();
        $comp = $this->CompForUser($user);
        $this->VotingForAComp($comp);
        $other = Factory::create('App\User');
        $this->be($other);
        $this->visit('/comp/submitions/'.$comp->id)
            ->see('neesiet')
            ->onPage('/');
    }

    /**
     * Tiek izvēlēts dzēst remiksa dziesmu no konkursa, kuram vēl notiek dziesmu iesūtīšana.
     */
    public function test_deleting_song_from_contest_subm_end_date_bigger_then_now()
    {
        $user = $this->DummyUser();
        $comp = $this->CompForUser($user);
        $voting = $this->VotingForAComp($comp);
        $song = $this->SongsForAComp($voting);
        $this->be($user);
        $this->visit('comp/submitions/'.$comp->id)
            ->press('Dzēst')
            ->see('Dziesma');
        $this->verifyInDatabase('submitions', ['title' => $song->title , 'status' => 'b']);
        $this->verifyInDatabase('notifications', ['user_id' => $song->user_id , 'type' => 'DeleteSubmition']);
    }

    /**
     * Tiek parādīts kļūdas paziņojums “Dziesmu iesūtīšana ir beigusies, jūs nevarat dzēst šo dziesmu!, notestēt grūti jo jābūt lapā, kad mainās datums.
     */
    public function test_deleting_song_from_contest_subm_end_date_smaller_then_now()
    {
        $user = $this->DummyUser();
        $comp = $this->SubmCompForUser($user);
        $voting = $this->VotingForAComp($comp);
        $song = $this->SongsForAComp($voting);
        $this->be($user);
        $this->visit('comp/submitions/'.$comp->id)
            ->see('--');
        $this->verifyInDatabase('submitions', ['title' => $song->title , 'status' => 'v']);
    }

    /**
     * Viesis mēģina piekļūt kādai no šim funkcijām.
     */
    public function test_guest_wants_to_use_functions()
    {
        $comp = $this->TestComp();
        $this->visit('comp/submitions/'.$comp->id)
            ->onPage('auth/login');
    }


}