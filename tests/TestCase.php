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

		$app = require __DIR__.'/../bootstrap/app.php';

		$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

		return $app;
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



}
