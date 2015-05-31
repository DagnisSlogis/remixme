<?php
/**
 * Created by PhpStorm.
 * User: Dagnis
 * Date: 27.05.2015.
 * Time: 9:52
 */

class JudgingTest extends TestCase {

    /**
     * Netiek novērtēta dziesma, dziesmu vietas tiek atstātas kā “0”
     */
    public function test_nothing_has_been_judged()
    {
        $user = $this->DummyUser();
        $comp = $this->SubmCompForUser($user);
        $voting = $this->VotingForACompShowned($comp);
        for($i=0;$i<3;$i++) {
            $this->SongsForAComp($voting);
        }
        $this->be($user);
        $this->visit('userpanel/judging')
            ->press('Vērtēt')
            ->select('place0' , '0')
            ->select('place1' , '0')
            ->select('place2' , '0')
            ->press('Saglabāt')
            ->see('Dziesmas')
            ->onPage('/comp/judge/'.$comp->id);
    }

    /**
     * Netiek novērtētas 3 dziesmas, kaut iesūtītas ir 3 vai vairāk dziesmu.
     */
    public function test_didnt_judge_3_songs_when_having_3_or_more_songs()
    {
        $user = $this->DummyUser();
        $comp = $this->SubmCompForUser($user);
        $voting = $this->VotingForACompShowned($comp);
        for($i=0;$i<4;$i++) {
            $this->SongsForAComp($voting);
        }
        $this->be($user);
        $this->visit('userpanel/judging')
            ->press('Vērtēt')
            ->select('place0' , '1')
            ->select('place1' , '2')
            ->select('place2' , '0')
            ->select('place3' , '0')
            ->press('Saglabāt')
            ->see('Dziesmas')
            ->onPage('/comp/judge/'.$comp->id);
    }

    /**
     * Netiek novērtētas 2 dziesmas, kaut iesūtītas ir 2.
     */
    public function test_didnt_judge_2_songs_when_having_2_songs()
    {
        $user = $this->DummyUser();
        $comp = $this->SubmCompForUser($user);
        $voting = $this->VotingForACompShowned($comp);
        for($i=0;$i<2;$i++) {
            $this->SongsForAComp($voting);
        }
        $this->be($user);
        $this->visit('userpanel/judging')
            ->press('Vērtēt')
            ->select('place0' , '1')
            ->select('place1' , '0')
            ->press('Saglabāt')
            ->see('Dziesmas')
            ->onPage('/comp/judge/'.$comp->id);
    }

    /**
     * Vairāk nekā 1 dziesma dala vienu un to pašu vietu.
     */
    public function test_more_then_one_song_has_the_same_place()
    {
        $user = $this->DummyUser();
        $comp = $this->SubmCompForUser($user);
        $voting = $this->VotingForACompShowned($comp);
        for($i=0;$i<4;$i++) {
            $this->SongsForAComp($voting);
        }
        $this->be($user);
        $this->visit('userpanel/judging')
            ->press('Vērtēt')
            ->select('place0' , '1')
            ->select('place1' , '2')
            ->select('place2' , '1')
            ->select('place3' , '3')
            ->press('Saglabāt')
            ->see('vietai')
            ->onPage('/comp/judge/'.$comp->id);
    }

    /**
     * Tiek ievadīti korekti dati.

     */
    public function test_judging_was_success()
    {
        $user = $this->DummyUser();
        $comp = $this->SubmCompForUser($user);
        $voting = $this->VotingForACompShowned($comp);
        for($i=0;$i<4;$i++) {
            $this->SongsForAComp($voting);
        }
        $this->be($user);
        $this->visit('userpanel/judging')
            ->press('Vērtēt')
            ->select('place0' , '1')
            ->select('place1' , '2')
            ->select('place2' , '3')
            ->select('place3' , '0')
            ->press('Saglabāt')
            ->see('Konkurss');
        $this->verifyInDatabase('votings', ['id' => $voting->id , 'status' => 'b']);
        $this->verifyInDatabase('winners', ['voting_id' => $voting->id , 'place' => '1']);
        $this->verifyInDatabase('winners', ['voting_id' => $voting->id , 'place' => '2']);
        $this->verifyInDatabase('winners', ['voting_id' => $voting->id , 'place' => '3']);
        $this->verifyInDatabase('notifications', ['comp_id' => $comp->id , 'show_date' => NULL]);
        $this->verifyInDatabase('notifications', ['comp_id' => $comp->id , 'type' => 'Winner']);
    }

    /**
     * Tiek vērtēts konkurss ar 0 dalībniekiem
     */
    public function test_noone_entered_the_comp()
    {
        $user = $this->DummyUser();
        $comp = $this->SubmCompForUser($user);
        $voting = $this->VotingForACompShowned($comp);
        $this->be($user);
        $this->visit('userpanel/judging')
            ->press('Vērtēt')
            ->see('nebija neviena');
        $this->verifyInDatabase('votings', ['id' => $voting->id , 'status' => 'b']);
        $this->verifyInDatabase('comps', ['id' => $comp->id , 'status' => 'b']);
    }
} 