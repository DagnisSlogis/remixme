<?php
/**
 * Created by PhpStorm.
 * User: Dagnis
 * Date: 21.05.2015.
 * Time: 10:59
 */
use Laracasts\TestDummy\Factory as TestDummy;
class UserFunctionTest extends TestCase {

    public function createBunchOfUsers()
    {
        for($i = 0 ; $i < 15 ; $i++)
        {
            TestDummy::create('App\User');
        }
    }

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
     * Administrators ievada kāda lietotāja e-pastu vai arī daļu no tā.
     */
    public function test_admin_search_for_user()
    {
        $search = 'test';
        $this->beAdmin();
        $this->DummyUser();
        $this->visit('adminpanel/users')
            ->type($search , 's')
            ->press('Meklēt')
            ->see('mazais@test.lv')
            ->onPage('/adminpanel/user/find?s='.$search);
    }

    /**
     * Administrators ievada kāda lietotāja lietotājvārdu vai arī daļu no tā.
     */
    public function test_admin_search_for_email()
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
     *
     */
    public function test_users_are_paginated()
    {
        $this->createBunchOfUsers();
        $this->beAdmin();
        $this->visit('adminpanel/users?page=2')
            ->onPage('adminpanel/users?page=2');
    }



} 