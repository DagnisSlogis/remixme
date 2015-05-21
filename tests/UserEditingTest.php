<?php
/**
 * Created by PhpStorm.
 * User: Dagnis
 * Date: 21.05.2015.
 * Time: 11:55
 */
use Laracasts\TestDummy\Factory as TestDummy;
class UserEditingTest extends TestCase {
    /**
     * Lietotājs neko nelabojot uzspiež pogu “Labot”
     */
    public function test_nothing_has_been_changed_pressed_labot()
    {
        $this->beUser();
        $this->visit('userpanel/profile/edit')
            ->press('Labot')
            ->onPage('userpanel');
        $this->beAdmin();
        $this->visit('adminpanel/users')
            ->click('Labot')
            ->press('Labot')
            ->onPage('adminpanel/users');
    }

    /**
     * Lietotājs izdzēš esošo, obligāto lietotāja informāciju un spiež “Labot”.
     */
    public function test_not_null_data_deleted_pressed_labot()
    {
        $this->beUser();
        $this->visit('userpanel/profile/edit')
            ->type('', 'username')
            ->press('Labot')
            ->onPage('userpanel');
        $this->verifyInDatabase('users', ['email' => 'mazais@test.lv' , 'username' => 'tester']);
        $this->beAdmin();
        $this->visit('adminpanel/users')
            ->click('Labot')
            ->type('', 'username')
            ->press('Labot')
            ->onPage('adminpanel/users');
        $this->verifyInDatabase('users', ['username' => 'tester']);
    }

    /**
     * Lietotājs ievada e-pastu/lietotājvārdu, kurš jau ir reģistrēts sistēmā.
     */
    public function test_edited_username_already_exists()
    {
        TestDummy::create('App\User', [
            'username' => 'tester2',
            'email' => 'mazais3@test.lv',
            'password' => 'test1234',
            'status' => 1,
        ]);
        $this->beUser();
        $this->visit('userpanel/profile/edit')
            ->type('tester2', 'username')
            ->press('Labot')
            ->see('The username has already been taken.')
            ->onPage('userpanel/profile/edit');
        $this->beAdmin();
        $this->visit('adminpanel/users')
            ->click('Labot')
            ->type('tester', 'username')
            ->press('Labot')
            ->see('The username has already been taken.');
    }

    /**
     * Tiek ievadīts īsāka e-pasta adrese par 5 simboliem, īsāks lietotājvārds par 4 simboliem.
     */
    public function test_edited_username_shorter()
    {
        $this->beUser();
        $this->visit('userpanel/profile/edit')
            ->type('tes', 'username')
            ->press('Labot')
            ->see('The username must be at least 4 characters.')
            ->onPage('userpanel/profile/edit');
        $this->beAdmin();
        $this->visit('adminpanel/users')
            ->click('Labot')
            ->type('tes', 'username')
            ->press('Labot')
            ->see('The username must be at least 4 characters.');
    }

    /**
     * Tiek ievadīts e-pasts, kas neatbilst e-pasta formātam
     */
    public function test_edited_email_wrong_format()
    {
        $this->beUser();
        $this->visit('userpanel/profile/edit')
            ->type('tes', 'email')
            ->press('Labot')
            ->see('Email')
            ->onPage('userpanel/profile/edit');
        $this->beAdmin();
        $this->visit('adminpanel/users')
            ->click('Labot')
            ->type('tes', 'email')
            ->press('Labot')
            ->see('Email');
    }

    /**
     * Tiek ievadīta parole, kas ir īsāka par 8 simboliem.
     */
    public function test_password_shorter()
    {
        $this->beUser();
        $this->visit('userpanel/profile/edit')
            ->type('test12', 'password')
            ->type('test12', 'password_confirmation')
            ->press('Labot')
            ->see('The password must be at least 8 characters.')
            ->onPage('userpanel/profile/edit');
    }

    /**
     * Ievadītā parole nesakrīt ar paroli, kas ir ievadīta laukā “Apstipriniet paroli”.
     */
    public function test_password_mismatch()
    {
        $this->beUser();
        $this->visit('userpanel/profile/edit')
            ->type('test1234', 'password')
            ->type('test12567', 'password_confirmation')
            ->press('Labot')
            ->see('Jaunā parole nesakrīt!')
            ->onPage('userpanel/profile/edit');
        $this->beAdmin();
        $this->visit('adminpanel/users')
            ->click('Labot')
            ->type('test12324234', 'password')
            ->type('test1232423222', 'password_confirmation')
            ->press('Labot')
            ->see('Jaunā parole nesakrīt!');
    }

    /**
     * Tiek izvēlēts “Dzēst profila attēlu” un nekas netiek augšupielādēts.
     */
    public function test_user_deleting_curent_img()
    {
        $this->beUser();
        $this->visit('userpanel/profile/edit')
            ->tick('delete_img')
            ->press('Labot')
            ->onPage('userpanel');
        $this->verifyInDatabase('users', ['username' => 'tester' , 'profile_img' => '/img/noImg.jpg']);
    }
    public function test_admin_deletes_user_current_img()
    {
        $this->DummyUser();
        $this->beAdmin();
        $this->visit('adminpanel/users')
            ->click('Labot')
            ->tick('delete_img')
            ->press('Labot')
            ->onPage('adminpanel/users');
        $this->verifyInDatabase('users', ['username' => 'tester' , 'profile_img' => '/img/noImg.jpg']);

    }
    /**
     * Administrators izvēlās lietotāja statusu Administrators/Lietotājs.
     */
    public function test_user_status_change()
    {
        $this->DummyUser();
        $this->beAdmin();
        $this->visit('adminpanel/users')
            ->click('Labot')
            ->select('status', '2')
            ->press('Labot')
            ->see('laboti!')
            ->onPage('adminpanel/users');
        $this->verifyInDatabase('users', ['username' => 'tester' , 'status' => '2']);
    }

    /**
     * Lietotājs izdzēš gan esošo, obligāto lietotāja informāciju, gan esošo neobligāto informāciju spiež “Labot”. Admin - tas pats
     */
    public function test_user_deletes_all_data_only_notnullable_saves()
    {
        $this->beUser();
        $this->visit('userpanel/profile/edit')
            ->type('', 'username')
            ->type('', 'email')
            ->type('', 'password')
            ->type('', 'password_confirmation')
            ->type('', 'facebook')
            ->press('Labot')
            ->onPage('/userpanel');
        $this->verifyInDatabase('users', ['username' => 'tester' , 'facebook' => '']);
    }
    public function test_admin_deletes_all_data_only_notnullable_saves()
    {
        $this->DummyUser();
        $this->beAdmin();
        $this->visit('adminpanel/users')
            ->click('Labot')
            ->type('', 'username')
            ->type('', 'email')
            ->type('', 'password')
            ->type('', 'password_confirmation')
            ->type('', 'facebook')
            ->press('Labot')
            ->see('laboti!')
            ->onPage('adminpanel/users');
        $this->verifyInDatabase('users', ['username' => 'tester' , 'facebook' => '']);
    }

    /**
     * Tiek ievadīti korekti lietotāja profila dati.
     */
    public function test_successfully_editing_profile()
    {
        $this->beUser();
        $this->visit('userpanel/profile/edit')
            ->type('nexttest', 'username')
            ->type('nexttest@super.lv', 'email')
            ->type('testtest12', 'password')
            ->type('testtest12', 'password_confirmation')
            ->press('Labot')
            ->onPage('/userpanel');
        $this->verifyInDatabase('users', ['username' => 'nexttest' ]);
        $this->beAdmin();
        $this->visit('adminpanel/users')
            ->click('Labot')
            ->type('admineris', 'username')
            ->type('admineris@super.lv', 'email')
            ->type('admineris22', 'password')
            ->type('admineris22', 'password_confirmation')
            ->press('Labot')
            ->see('laboti!')
            ->onPage('adminpanel/users');
        $this->verifyInDatabase('users', ['username' => 'admineris']);
    }

    public function test_admin_deletes_user()
    {
        $this->DummyUser();
        $this->beAdmin();
        $this->visit('adminpanel/users')
            ->press('Dzēst')
            ->see('Lietot')
            ->onPage('adminpanel/users');
        $this->verifyInDatabase('users', ['username' => 'tester' , 'status' => '3']);
    }
} 