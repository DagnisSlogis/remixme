<?php

use Laracasts\Integrated\Services\Laravel\DatabaseTransactions;
use Laracasts\TestDummy\Factory as TestDummy;


class TestCase extends Laracasts\Integrated\Extensions\Laravel {

    use DatabaseTransactions;
	/**
	 * Creates the application.
	 *
	 * @return \Illuminate\Foundation\Application
	 */
	public function createApplication()
	{
        $unitTesting = true;
        $testEnvironment = 'testing';
		$app = require __DIR__.'/../bootstrap/app.php';

		$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

		return $app;
	}

    /**
     * Migrates the database and set the mailer to 'pretend'.
     * This will cause the tests to run quickly.
     *
     */
    private function prepareForTests()
    {
        Artisan::call('migrate');
        Mail::pretend(true);
    }

    /**
     * Default preparation for each test
     *
     */
    public function setUp()
    {
        parent::setUp(); // Don't forget this!

        $this->prepareForTests();
    }
    public function DummyUser()
    {
        return TestDummy::create('App\User', [
            'username' => 'tester',
            'email' => 'mazais@test.lv',
            'password' => 'test1234',
            'status' => 1,
        ]);
    }
    public function DummyAdmin()
    {
        return TestDummy::create('App\User', [
            'username' => 'admin',
            'email' => 'admin@admin.lv',
            'password' => 'test1234',
            'status' => 2,
        ]);
    }
    public function beAdmin()
    {
        $user = $this->DummyAdmin();
        $this->be($user);
    }
    public function beUser()
    {
        $user = $this->DummyUser();
        $this->be($user);
    }

    public function Comp()
    {
        $this->visit('/comps/create')
            ->type('CompTitle', 'title')
            ->select('preview_type', 'y')
            ->type( 'https://www.youtube.com/watch?v=eL-rEbUmLNU' , 'preview_link')
            ->type( 'testaaa','description' )
            ->type('testaaa','rules')
            ->type('testaaa', 'prizes')
            ->type( 'testaaa', 'song_title')
            ->type( 'testaaa', 'stem_link' )
            ->select('comp_end_date', '2015-07-22')
            ->select('subm_end_date', '2015-07-12')
            ->select('voting_type', 'b')
            ->press('Izveidot')
            ->see('gaidiet')
            ->onPage('/');
    }

    public function bunchofComps()
    {
        for($i = 0 ; $i < 15 ; $i++)
        {
            TestDummy::create('App\Comp');
        }
    }

    public function otherUserComp()
    {
        $user = TestDummy::create('App\User', [
            'username' => 'lietotājs',
            'email' => 'admisdsan@admsadasin.lv',
            'password' => 'test1234',
            'status' => 1,
        ]);
        $this->be($user);
        $this->visit('/comps/create')
            ->type('CompTitle22', 'title')
            ->select('preview_type', 'y')
            ->type( 'https://www.youtube.com/watch?v=eL-rEbUmLNU' , 'preview_link')
            ->type( 'testaaa','description' )
            ->type('testaaa','rules')
            ->type('testaaa', 'prizes')
            ->type( 'testaaa', 'song_title')
            ->type( 'testaaa', 'stem_link' )
            ->select('comp_end_date', '2015-07-12')
            ->select('subm_end_date', '2015-07-09')
            ->select('voting_type', 'b')
            ->press('Izveidot');
    }

    public function newAcceptedComp()
    {
        $this->beUser();
        $this->visit('/comps/create')
            ->type('CompTitle', 'title')
            ->select('preview_type', 'y')
            ->type( 'https://www.youtube.com/watch?v=eL-rEbUmLNU' , 'preview_link')
            ->type( 'testaaa','description' )
            ->type('testaaa','rules')
            ->type('testaaa', 'prizes')
            ->type( 'testaaa', 'song_title')
            ->type( 'testaaa', 'stem_link' )
            ->select('comp_end_date', '2015-07-22')
            ->select('subm_end_date', '2015-07-12')
            ->select('voting_type', 'b')
            ->press('Izveidot')
            ->see('gaidiet')
            ->onPage('/');
        $this->beAdmin();
        $this->visit('/adminpanel/comps/accept')
            ->press('Apstiprināt')
            ->see('Konkurss')
            ->onPage('/adminpanel/comps/accept');
        $this->verifyInDatabase('comps', ['title' => 'CompTitle' , 'status' => 'v']);

    }

    public function createTestUser()
    {
        return TestDummy::create('App\User', [
            'username' => 'testuser',
            'email' => 'testuser@admin.lv',
            'password' => 'test1234',
            'status' => 1,
            'id' => 1,
        ]);
    }

    public function someonesComp()
    {
        return
            TestDummy::create('App\Comp', [
            'title' => 'testuser',
            'subm_end_date' => '2015-09-21',
            'comp_end_date' => '2015-09-27',
            'status' => 'v',
        ]);
    }


    /**
     * Testa konkurss
     * @return mixed
     */
    public function TestComp()
    {
        return TestDummy::create('App\Comp',['subm_end_date' => '2015-08-09' ,'comp_end_date'  => '2015-08-18']);
    }

    /**
     * Izveido ierakstu Voting tabulā
     *
     * @param $comp
     * @return mixed
     */
    public function VotingForAComp($comp)
    {
        return TestDummy::create('App\Voting',[
            'comp_id' => $comp->id,
            'show_date' => '2015-09-28'
        ]);
    }

    public function VotingForACompShowned($comp)
    {
        return TestDummy::create('App\Voting',[
            'comp_id' => $comp->id,
            'show_date' => '2015-04-10'
        ]);
    }


    /**
     * Izveido konkrusam dziesmas
     *
     * @param $voting
     * @return mixed
     */
    public function SongsForAComp($voting)
    {
        return TestDummy::create('App\Submition', [
            'comp_id' => $voting->comp_id,
            'voting_id' => $voting->id,
        ]);
    }

    /**
     * Izveido konkursu priekš lietotāja, kursh ir 1. posma
     *
     * @param $user
     * @return mixed
     */
    public function CompForUser($user)
    {
        return TestDummy::create('App\Comp',['subm_end_date' => '2015-08-09' ,
            'comp_end_date'  => '2015-08-18',
            'user_id' => $user->id,
        ]);
    }

    /**
     *
     * Izveido beigušos konkursu ar balsošanas tipu Žūrija
     * @param $user
     * @return mixed
     */
    public function SubmCompForUser($user)
    {
        return TestDummy::create('App\Comp',['subm_end_date' => '2015-04-09' ,
            'comp_end_date'  => '2015-08-18',
            'user_id' => $user->id,
            'voting_type' => 'z',
        ]);
    }
}
