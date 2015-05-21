<?php

use Laracasts\TestDummy\Factory as TestDummy;
class UserRegistrationTest extends TestCase
{
    /**
     * Obligāto datu lauki tiek atstāti neizpildīti.
     */
    public function test_registration_fields_are_empty()
    {
        $this->visit('auth/register')
            ->type('', 'username')
            ->type('', 'email')
            ->type('', 'password')
            ->type('', 'password_confirmation')
            ->press('Reģistrēties')
            ->see('class="alert"')
            ->onPage('auth/register');
    }

    /**
     * Tiek ievadīts īsāka e-pasta adrese par 5 simboliem, īsāks lietotājvārds par 4 simboliem.
     */
    public function test_email_login_are_shorter()
    {
        $this->visit('auth/register')
            ->type('tes', 'username')
            ->type('test', 'email')
            ->type('test1234', 'password')
            ->type('test1234', 'password_confirmation')
            ->press('Reģistrēties')
            ->see('The username must be at least 4 characters.')
            ->onPage('auth/register');
    }

    /**
     * Tiek ievadīts e-pasts, kas neatbilst e-pasta formātam
     */
    public function test_email_doesnt_have_email_format()
    {
        $this->visit('auth/register')
            ->type('testeris', 'username')
            ->type('test', 'email')
            ->type('test1234', 'password')
            ->type('test1234', 'password_confirmation')
            ->press('Reģistrēties')
            ->see('Email')
            ->onPage('auth/register');
    }

    /**
     * Tiek ievadīta parole, kas ir īsāka par 8 simboliem.
     */
    public function test_password_less_than_minimum()
    {
        $this->visit('auth/register')
            ->type('testeris', 'username')
            ->type('test@test.lv', 'email')
            ->type('test1', 'password')
            ->type('test1', 'password_confirmation')
            ->press('Reģistrēties')
            ->see('The password must be at least 8 characters.')
            ->onPage('auth/register');
    }

    /**
     * Ievadītā parole nesakrīt ar paroli, kas ir ievadīta laukā “Apstipriniet paroli”.
     */
    public function test_password_mismatch()
    {
        $this->visit('auth/register')
            ->type('testeris', 'username')
            ->type('test@test.lv', 'email')
            ->type('test1234', 'password')
            ->type('test12345', 'password_confirmation')
            ->press('Reģistrēties')
            ->see('The password confirmation does not match.')
            ->onPage('auth/register');
    }

    /**
     * Pārbauda vai e-pasts vai lietotājvārds nav jau reģistrēts Db.
     */
    public function test_if_user_already_exists()
    {
        TestDummy::create('App\User', [
            'username' => 'testeris',
            'email' => 'test@test.lv',
            'password' => 'test1234',
        ]);
        $this->verifyInDatabase('users', ['username' => 'testeris']);
        $this->visit('auth/register')
            ->type('testeris', 'username')
            ->type('test@test.lv', 'email')
            ->type('test1234', 'password')
            ->type('test1234', 'password_confirmation')
            ->press('Reģistrēties')
            ->see('The username has already been taken.')
            ->onPage('auth/register');
    }

    /*public function test_image_size_over_1000()
    {


    }*/

    /**
     * Tiek ievadīti korekti reģistrācijas dati.
     */
    public function test_created_a_user()
    {
        $this->visit('auth/register')
            ->type('testeris', 'username')
            ->type('test@test.lv', 'email')
            ->type('test12345', 'password')
            ->type('test12345', 'password_confirmation')
            ->press('Reģistrēties')
            ->see('testeris')
            ->onPage('/');
        $this->verifyInDatabase('users', ['username' => 'testeris']);

    }

}