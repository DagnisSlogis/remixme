<?php
/**
 * Created by PhpStorm.
 * User: Dagnis
 * Date: 21.05.2015.
 * Time: 15:22
 */

class CompRegistrationTest extends TestCase {


    /**
     * Obligāto datu lauki tiek atstāti neizpildīti.
     */
    public  function test_comp_form_fields_are_empty()
    {
        $this->beUser();
        $this->visit('/comps/create')
            ->press('Izveidot')
            ->see('class="alert"')
            ->onPage('/comps/create');
    }

    /**
     * Tiek ievadīti īsāki dati, nekā minimālais garums.
     */
    public function test_comp_name_or_song_name_genre_too_shot()
    {
        $this->beUser();
        $this->visit('/comps/create')
            ->type('tes','title')
            ->type('tes','song_title')
            ->type('za','genre')
            ->press('Izveidot')
            ->see('title vajag būt vismaz')
            ->onPage('/comps/create');
    }

    /**
     * Tiek aizpildīti ievades dati, konkursa beigu datums ir mazāks par iesūtīšanas datumu vai arī tie ir mazāki par šīs dienas datumu.
     */
    public function test_comp_end_date_and_subm_date_doesnt_validate()
    {
        $this->beUser();
        $this->visit('/comps/create')
            ->type('CompTitle', 'title')
            ->select('preview_type', 's')
            ->type( 'https://soundcloud.com/dirty-ducks/dirty-ducks-and-big-nab-lets-rock-out-now' , 'preview_link')
            ->type( 'testaaa','description' )
            ->type('testaaa','rules')
            ->type('testaaa', 'prizes')
            ->type( 'testaaa', 'song_title')
            ->type( 'testaaa', 'stem_link' )
            ->select('comp_end_date', '2015-05-12')
            ->select('subm_end_date', '2015-05-12')
            ->select('voting_type', 'b')
            ->press('Izveidot')
            ->see('Datumiem')
            ->onPage('/comps/create');
    }

    /**
     * Tiek ievadīts konkursa beigu datums/iesūtīšanas beigu datums, kas neatbilst datuma formātam.
     */
    public function test_comp_date_format_is_not_valid()
    {
        $this->beUser();
        $this->visit('/comps/create')
            ->type('CompTitle', 'title')
            ->select('preview_type', 's')
            ->type( 'https://soundcloud.com/dirty-ducks/dirty-ducks-and-big-nab-lets-rock-out-now' , 'preview_link')
            ->type( 'testaaa','description' )
            ->type('testaaa','rules')
            ->type('testaaa', 'prizes')
            ->type( 'testaaa', 'song_title')
            ->type( 'testaaa', 'stem_link' )
            ->select('comp_end_date', '20152323')
            ->select('subm_end_date', '20152322')
            ->select('voting_type', 'b')
            ->press('Izveidot')
            ->see('nav datuma')
            ->onPage('/comps/create');
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

    }*/

    /**
     * Dziesma atrodama tiek izvēlēts “Soundcloud”. Laukā adrese tiek ievadīta saite no soundcloud.com
     */
    public function test_link_type_s_saves_valid_link()
    {
        $this->beUser();
        $this->visit('/comps/create')
            ->type('CompTitle', 'title')
            ->select('preview_type', 's')
            ->type( 'https://soundcloud.com/dirty-ducks/dirty-ducks-and-big-nab-lets-rock-out-now' , 'preview_link')
            ->type( 'testaaa','description' )
            ->type('testaaa','rules')
            ->type('testaaa', 'prizes')
            ->type( 'testaaa', 'song_title')
            ->type( 'testaaa', 'stem_link' )
            ->select('comp_end_date', '2015-07-22')
            ->select('subm_end_date', '2015-07-12')
            ->select('voting_type', 'b')
            ->press('Izveidot')
            ->onPage('/');
        $this->verifyInDatabase('comps', ['title' => 'CompTitle' , 'preview_type' => 's' , 'preview_link' => 'https://soundcloud.com/dirty-ducks/dirty-ducks-and-big-nab-lets-rock-out-now']);
    }

    /**
     * Dziesma atrodama tiek izvēlēts “Youtube”. Laukā adrese tiek ievadīta saite no youtube.com
     */
    public function test_link_type_y_saves_valid_link()
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
            ->onPage('/');
        $this->verifyInDatabase('comps', ['title' => 'CompTitle' , 'preview_type' => 'y' , 'preview_link' => 'https://www.youtube.com/embed/eL-rEbUmLNU']);
    }

    /**
     * Visi lauki tiek izpildīti korekti.
     */
    public function test_valid_comp_creation()
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
        $this->verifyInDatabase('comps', ['title' => 'CompTitle' , 'status' => 'a']);
    }

    /**
     * Viesis mēģina izveidot konkursu.
     */
    public function test_guest_tries_to_create_a_comp()
    {
        $this->visit('/comps/create')
            ->onPage('auth/login');
    }


}