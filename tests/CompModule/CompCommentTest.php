<?php
/**
 * Created by PhpStorm.
 * User: Dagnis
 * Date: 22.05.2015.
 * Time: 21:31
 */
use Laracasts\TestDummy\Factory as TestDummy;
class CompCommentTest extends TestCase{


    /**
     * Tiek izvēlēts apskatīties kāda konkursa komentārus
     */
    public function test_see_comp_comments()
    {
        $this->beUser();
        $comp = $this->TestComp();
        $this->VotingForAComp($comp);
        $this->visit('/')
            ->click('Komentāri')
            ->see('Komentēt');
    }

    /**
     * Netiek ievadīts komentāra teksts, tiek uzspiesta poga “Komentēt”
     */
    public function test_no_comment_text_entered_and_submited()
    {
        $this->beUser();
        $comp = $this->TestComp();
        $this->VotingForAComp($comp);
        $this->visit('/')
            ->click('Komentāri')
            ->type('' , 'text')
            ->press('Komentēt')
            ->see('text lauks');
    }

    /**
     * Tiek ievadīts komentāra teksts, tiek uzspiesta poga “Komentēt”
     */
    public function test_comment_text_is_valid()
    {
        $this->beUser();
        $user = \App\User::first();
        $comp = $this->TestComp();
        $this->VotingForAComp($comp);
        $this->visit('/')
            ->click('Komentāri')
            ->type('brumbrum' , 'text')
            ->press('Komentēt')
            ->see('brumbrum');
        $this->verifyInDatabase('comments', ['text' => 'brumbrum' , 'user_id' => $user->id]);
        return $user;
    }

    /**
     * Lietotājs dzēš savu komentāru
     */
    public function test_user_deletes_his_comment()
    {
        $user = $this->test_comment_text_is_valid();
        $this->visit('/')
            ->click('Komentāri')
            ->press('x');
        $this->verifyInDatabase('comments', ['user_id' => $user->id , 'status' => 'b']);
    }

    /**
     * Administrators dzēš komentāru
     */
    public function test_admin_deletes_other_user_comments()
    {
        $user = $this->test_comment_text_is_valid();
        $this->beAdmin();
        $this->visit('/')
            ->click('Komentāri')
            ->press('x');
        $this->verifyInDatabase('comments', ['user_id' => $user->id , 'status' => 'b']);
    }

    /**
     * Viesis izvēlās apskatīt kāda konkursa komentārus
    */
    public function test_guest_tries_to_see_comment_form()
    {
        $comp = $this->TestComp();
        $this->VotingForAComp($comp);
        $this->visit('/')
            ->click('Komentāri')
            ->notsee('Komentēt');
    }

} 