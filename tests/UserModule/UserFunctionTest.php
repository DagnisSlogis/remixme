<?php
/**
 * Created by PhpStorm.
 * User: Dagnis
 * Date: 21.05.2015.
 * Time: 10:59
 */
use Laracasts\TestDummy\Factory as TestDummy;
class UserFunctionTest extends TestCase {


    /**
     * Administrators izvēlās parādīts visus sistēmas lietotājus.
     */
    public function test_admin_can_see_all_users()
    {
        $this->beAdmin();
        $this->DummyUser();
        $this->visit('/adminpanel/users')
            ->see('tester')
            ->onPage('/adminpanel/users');
    }

    /**
     * Administrators meklēšanas formā ievada kāda lietotāja e-pastu vai lietotājvārdu.
     */
    public function test_admin_search_for_user_by_email_or_username()
    {
        $search = 'mazais@test.lv';
        $this->beAdmin();
        $this->DummyUser();
        $this->visit('adminpanel/users')
            ->type($search , 's')
            ->press('Meklēt')
            ->see('mazais@test.lv')
            ->onPage('/adminpanel/user/find?s=mazais%40test.lv');
    }

    /**
     * Administrators meklēšanas formā ievada meklējamo vārdu.
     */
    public function test_admin_search_for_searchword()
    {
        $search = 'maza';
        $this->beAdmin();
        $this->DummyUser();
        $this->visit('adminpanel/users')
            ->type($search , 's')
            ->press('Meklēt')
            ->see('mazais@test.lv')
            ->onPage('/adminpanel/user/find?s='.$search);
    }

    /**
     * Administrators ievada vārdu, kas nav atrodams ne lietotājvārdā, ne e-pasta adresē.
     */
    public function test_try_to_find_not_existing_user()
    {
        $search = 'alma';
        $this->beAdmin();
        $this->DummyUser();
        $this->visit('adminpanel/users')
            ->type($search , 's')
            ->press('Meklēt')
            ->see($search)
            ->onPage('/adminpanel/user/find?s='.$search);
    }

    /**
     * Lietotājs, viesis mēģina piekļūt administratora funkcijām. ( Lietotājs)
     */
    public function test_user_cant_use_admin_functions()
    {
        $this->beUser();
        $this->visit('/adminpanel/users')
            ->onPage('/');
    }

    /**
     * Lietotājs, viesis mēģina piekļūt administratora funkcijām. (Viesis)
     */
    public function test_guest_cant_use_admin_functions()
    {
        $this->visit('/adminpanel/users')
            ->onPage('/auth/login');
    }



} 