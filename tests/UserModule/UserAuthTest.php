<?php
/**
 * Created by PhpStorm.
 * User: Dagnis
 * Date: 20.05.2015.
 * Time: 22:29
 */
use Laracasts\TestDummy\Factory as TestDummy;
class UserAuthTest extends TestCase{

    /**
     * Tiek ievadīti nepareiza parole un e-pasts
     */
    public function test_email_password_doesnt_match()
    {
        $this->User();
        $this->visit('/')
            ->type('test@test.lv', 'email')
            ->type('test123', 'password')
            ->press('Pieslēgties')
            ->see('These credentials do not match our records.')
            ->onPage('/auth/login');
    }

    /**
     * Mēģina pieslēgties sistēmai ar lietotāja kontu, kurš ir bloķēts.
     */
    public function test_try_to_auth_as_blocked()
    {
        $this->DummyBlocked();
        $this->verifyInDatabase('users', ['username' => 'blocked']);
        $this->visit('/')
            ->type('blocked@blocked.lv', 'email')
            ->type('test1234', 'password')
            ->press('Pieslēgties')
            ->onPage('/');
    }

    /**
     * Atkārtoti ievadot autentifikācijas datus, viens no ievades logiem netiek aizpildīts.
     */
    public function test_trying_again_not_filling_all_data()
    {
        $this->User();
        $this->visit('/auth/login')
            ->type('test@test.lv', 'email')
            ->type('', 'password')
            ->press('Pieslēgties')
            ->see('password lauks ir')
            ->onPage('/auth/login');
    }

    /**
     * Tiek ievadīti korekts e-pasts un parole.
     */
    public function test_login_correctly()
    {
        $this->User();
        $this->visit('auth/login')
            ->type('test@test.lv', 'email')
            ->type('test12345', 'password')
            ->press('Pieslēgties')
            ->see('testeris')
            ->onPage('/');
    }

    /**
     * Tiek uzspiesta iziešanas ikona.
     */
    public function test_can_logout()
    {
        $this->beUser();
        $this->visit('/')
            ->see('tester');
        $this->visit('auth/logout')
            ->see('Piesl')
            ->onPage('/');
    }

    /**
     * Tiek izveidots bloķēts lietotājs
     * @return mixed
     */
    private function DummyBlocked()
    {
        return TestDummy::create('App\User', [
            'username' => 'blocked',
            'email' => 'blocked@blocked.lv',
            'password' => 'test1234',
            'status' => 3,
        ]);
    }

    /**
     * Jauns konts ko izveido lietotājs
     */
    private function User()
    {
        $this->visit('auth/register')
            ->type('testeris', 'username')
            ->type('test@test.lv', 'email')
            ->type('test12345', 'password')
            ->type('test12345', 'password_confirmation')
            ->press('Reģistrēties')
            ->see('testeris')
            ->onPage('/');
        $this->visit('auth/logout');
    }
} 