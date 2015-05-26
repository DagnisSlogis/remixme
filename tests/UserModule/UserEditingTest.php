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
     * Netiek laboti ievades lauki, spiež “Labot”
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
     * Tiek izdzēsta esošā, obligātā lietotāja informāciju un spiež “Labot”.
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
     * Tiek ievadīts e-pasts/lietotājvārds, kurš jau ir reģistrēts sistēmā.
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
            ->see('username ir jau izmantots.')
            ->onPage('userpanel/profile/edit');
        $this->beAdmin();
        $this->visit('adminpanel/users')
            ->click('Labot')
            ->type('tester', 'username')
            ->press('Labot')
            ->see('username ir jau izmantots.');
    }

    /**
     * Tiek ievadīts īsāki lietotāja dati, nekā prasīts.
     */
    public function test_edited_username_shorter()
    {
        $this->beUser();
        $this->visit('userpanel/profile/edit')
            ->type('tes', 'username')
            ->press('Labot')
            ->see('simboli')
            ->onPage('userpanel/profile/edit');
        $this->beAdmin();
        $this->visit('adminpanel/users')
            ->click('Labot')
            ->type('tes', 'username')
            ->press('Labot')
            ->see('simboli');
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
            ->see('vismaz')
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
     * Tiek augšupielādēta bilde, kas lielāka pa 1mb
     */
    /*public function test_image_size_over_1000()
    {


    }*/

    /**
     * Tiek augšupielādēts fails, kas nav formātos jpeg/png,
     */
    /*public function test_image_format_isnt_jpg_png()
    {
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
    /**
     * Administrators izvēlās lietotāja statusu.
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
     * Tiek izdzēsta gan esošā, obligātā lietotāja informāciju, gan esošā, neobligātā informāciju spiež “Labot”. pats
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

    /**
     * Viesis mēģina labot profilu
     */
    public function test_guest_tries_to_edit_profile()
    {
        $this->visit('userpanel/profile/edit')
            ->onPage('auth/login');
    }


    /**
     * Administrators izvēlās dzēst kādu lietotāju no sistēmas
     */
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

    public function test_user_tries_to_delete_another_user()
    {
        $this->beUser();
        $this->visit('adminpanel/users')
            ->onPage('/');
    }
} 