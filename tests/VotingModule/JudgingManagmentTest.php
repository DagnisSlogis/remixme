<?php
use Laracasts\TestDummy\Factory;

/**
 * Created by PhpStorm.
 * User: Dagnis
 * Date: 26.05.2015.
 * Time: 22:24
 */

class JudgingManagmentTest extends TestCase {


    /**
     * Konkursa rīkotājs apskata vērtējamos r.k.
     */
    public function test_comp_owner_visist_judging_page()
    {
        $user = $this->DummyUser();
        $comp = $this->SubmCompForUser($user);
        $this->VotingForACompShowned($comp);
        $this->be($user);
        $this->visit('userpanel/judging')
            ->see($comp->title);
    }

    /**
     * Tiek izvēlēts novērtēt kādu konkursu, kurš ir 2. posmā.
     */
    public function test_comp_owner_wants_to_judge_comp()
    {
        $user = $this->DummyUser();
        $comp = $this->SubmCompForUser($user);
        $voting = $this->VotingForACompShowned($comp);
        $song = $this->SongsForAComp($voting);
        $this->be($user);
        $this->visit('userpanel/judging')
            ->press('Vērtēt')
            ->see($song->title);
    }

    /**
     * Cits lietotājs, vēlās novērtēt kāda cita lietotāja konkursu.
     */
    public function test_not_owner_wants_to_judge_others_comp()
    {
        $user = $this->DummyUser();
        $comp = $this->SubmCompForUser($user);
        $voting = $this->VotingForACompShowned($comp);
        $this->SongsForAComp($voting);
        $otheruser = Factory::create('App\User');
        $this->be($otheruser);
        $this->visit('comp/judge/'.$comp->id)
            ->onPage('/');
    }

    /**
     * Viesis mēģina izpildīt kādu no minētajām darbībām.
     */
    public function test_guest_tries_to_judge()
    {
        $user = $this->DummyUser();
        $comp = $this->SubmCompForUser($user);
        $voting = $this->VotingForACompShowned($comp);
        $this->SongsForAComp($voting);
        $this->visit('userpanel/judging')
            ->onPage('auth/login');
        $this->visit('userpanel/judging')
            ->onPage('auth/login');
        $this->visit('comp/judge/'.$comp->id)
            ->onPage('auth/login');
    }
} 