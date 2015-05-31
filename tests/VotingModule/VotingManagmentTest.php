<?php
/**
 * Created by PhpStorm.
 * User: Dagnis
 * Date: 27.05.2015.
 * Time: 10:33
 */

class VotingManagmentTest extends TestCase{

    /**
     * Konkursa rīkotājs izvēlās apskatīties savus r.k., kuru tips ir “Balsošana”
     */
    public function test_comp_owner_wants_to_see_votable_comps()
    {
        $user = $this->DummyUser();
        $comp = $this->VotingCompForUser($user);
        $this->VotingForACompShowned($comp);
        $this->be($user);
        $this->visit('userpanel/voting')
            ->see($comp->title);
    }

    /**
     * Izvēlās apskatīties dziesmas par kurām var balsot konkursā.
     */
    public function test_comp_ower_wants_to_see_votable_entrys()
    {
        $user = $this->DummyUser();
        $comp = $this->VotingCompForUser($user);
        $this->VotingForACompShowned($comp);
        $this->be($user);
        $this->visit('userpanel/voting')
            ->click('dziesmas')
            ->onPage('comp/submitions/'.$comp->id);
    }

    /**
     * Viesis mēģina izsaukt kādu no šīm darbībām.
     */
    public function test_guest_wants_see_votings()
    {
        $this->visit('userpanel/voting')
            ->onPage('auth/login');
    }

    /**
     * Konkursa rīkotājs izvēlās apstiprināt balsojuma rezultātus spiežot uz pogas “Apstiprināt”.
     */
    public function test_accepting_voting_results()
    {
        $user = $this->DummyUser();
        $comp = $this->VotingCompForUser($user);
        $voting = $this->VotingForACompShowned($comp);
        $this->be($user);
        for($i=0;$i<4;$i++) {
            $this->SongsForAComp($voting);
        }
        $this->visit('userpanel/voting')
            ->press('Apstiprināt');
        $this->verifyInDatabase('votings', ['id' => $voting->id , 'status' => 'b']);
        $this->verifyInDatabase('winners', ['voting_id' => $voting->id , 'place' => '1']);
        $this->verifyInDatabase('winners', ['voting_id' => $voting->id , 'place' => '2']);
        $this->verifyInDatabase('winners', ['voting_id' => $voting->id , 'place' => '3']);
        $this->verifyInDatabase('notifications', ['comp_id' => $comp->id , 'type' => 'Winner']);
    }

    public function test_no_one_entered()
    {
        $user = $this->DummyUser();
        $comp = $this->VotingCompForUser($user);
        $voting = $this->VotingForACompShowned($comp);
        $this->be($user);
        $this->visit('userpanel/voting')
            ->press('Apstiprināt')
            ->see('nebija neviena');
        $this->verifyInDatabase('votings', ['id' => $voting->id , 'status' => 'b']);
        $this->verifyInDatabase('comps', ['id' => $comp->id , 'status' => 'b']);
    }

} 