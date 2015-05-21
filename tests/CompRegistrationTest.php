<?php
/**
 * Created by PhpStorm.
 * User: Dagnis
 * Date: 21.05.2015.
 * Time: 15:22
 */
use Laracasts\TestDummy\Factory as TestDummy;

class CompRegistrationTest extends TestCase {


    /**
     * Obligāto datu lauki tiek atstāti neizpildīti.
     */
    public  function test_comp_form_fields_are_empty()
    {
        $this->beUser();
        $this->visit('/comps/create')
            ->press('Izveidot')
            ->see('The title field is required.')
            ->onPage('/comps/create');
    }

    /**
     * Tiek ievadīts Konkursa nosaukums/Dziesmas nosaukums vai žanrs un tas ir īsāks nekā vajadzīgs
     */
    public function test_comp_name_or_song_name_genre_too_shot()
    {
        $this->beUser();
        $this->visit('/comps/create')
            ->type('tes','title')
            ->type('tes','song_title')
            ->type('za','genre')
            ->press('Izveidot')
            ->see('The title must be at least 5 characters.')
            ->onPage('/comps/create');
    }

    /*public function test_comp_end_date_and_subm_date_doesnt_validate()
    {
        $this->beUser();
        $this->visit('/comps/create')
            ->type('CompTitle', 'title')
            ->select('preview_type', 's')
            ->type( 'https://soundcloud.com/dirty-ducks/dirty-ducks-and-big-nab-lets-rock-out-now' , 'preview_link')
            ->type( 'testaaa','description' )
            ->type('testaaa','rules')
            ->type('testaaa', 'prizes')
            ->attachFile('header_img',  __DIR__.'/testimg/test2.png')
            ->type( 'testaaa', 'song_title')
            ->type( 'testaaa', 'stem_link' )
            ->select('comp_end_date', '2015-05-12')
            ->select('subm_end_date', '2015-05-12')
            ->select('voting_type', 'b')
            ->press('Izveidot')->dump();
    }*/


} 