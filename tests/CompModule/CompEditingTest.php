<?php
/**
 * Created by PhpStorm.
 * User: Dagnis
 * Date: 22.05.2015.
 * Time: 19:58
 */

class CompEditingTest extends TestCase{

    /**
     * Konkursa labošanas formā netiek laboti dati, tiek uzspiests “Labot”
     */
    public function test_edit_comp_but_nothing_has_been_changed()
    {
        $this->beUser();
        $this->Comp();
        $this->visit('userpanel/comps')
            ->click('Labot')
            ->press('Labot')
            ->see('Nekas');
    }

    /**
     * Netiek izpildīti obligātie lauki.
     */
    public function test_edit_comp_notnull_forms_not_filled()
{
    $this->beUser();
    $this->Comp();
    $this->visit('userpanel/comps')
        ->click('Labot')
        ->type('', 'title')
        ->select('preview_type', 'y')
        ->type( 'https://www.youtube.com/watch?v=eL-rEbUmLNU' , 'preview_link')
        ->type( 'testaaa','description' )
        ->type('testaaa','rules')
        ->type('testaaa', 'prizes')
        ->type( '', 'song_title')
        ->type( 'testaaa', 'stem_link' )
        ->press('Labot')
        ->see('title lauks ');
}

    /**
     * Tiek ievadīti dati, kas ir īsāki nekā prasīts.
     */
    public function test_edit_comp_fields_are_shorter()
    {
        $this->beUser();
        $this->Comp();
        $this->visit('userpanel/comps')
            ->click('Labot')
            ->type('as', 'title')
            ->select('preview_type', 'y')
            ->type( 'https://www.youtube.com/watch?v=eL-rEbUmLNU' , 'preview_link')
            ->type( 'testaaa','description' )
            ->type('testaaa','rules')
            ->type('testaaa', 'prizes')
            ->type( 'asdasdasdas', 'song_title')
            ->type( 'testaaa', 'stem_link' )
            ->press('Labot')
            ->see('vismaz');
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
    public function test_edit_comp_link_type_s_saves_valid_link()
    {
        $this->beUser();
        $this->Comp();
        $this->visit('userpanel/comps')
            ->click('Labot')
            ->type('CompTitle', 'title')
            ->select('preview_type', 's')
            ->type( 'https://soundcloud.com/dirty-ducks/dirty-ducks-and-big-naab-lets-rock-out-now' , 'preview_link')
            ->type( 'testaaa','description' )
            ->type('testaaa','rules')
            ->type('testaaa', 'prizes')
            ->type( 'testaaa', 'song_title')
            ->type( 'testaaa', 'stem_link' )
            ->press('Labot');
        $this->verifyInDatabase('comps', ['title' => 'CompTitle' , 'preview_type' => 's' , 'preview_link' => 'https://soundcloud.com/dirty-ducks/dirty-ducks-and-big-naab-lets-rock-out-now']);
    }

    /**
     * Dziesma atrodama tiek izvēlēts “Youtube”. Laukā adrese tiek ievadīta saite no youtube.com
     */
    public function test_edit_comp_link_type_y_saves_valid_link()
    {
        $this->beUser();
        $this->Comp();
        $this->visit('userpanel/comps')
            ->click('Labot')
            ->type('CompTitle', 'title')
            ->select('preview_type', 'y')
            ->type( 'https://www.youtube.com/watch?v=eL-rEbUmLdNU' , 'preview_link')
            ->type( 'testaaa','description' )
            ->type('testaaa','rules')
            ->type('testaaa', 'prizes')
            ->type( 'testaaa', 'song_title')
            ->type( 'testaaa', 'stem_link' )
            ->press('Labot');
        $this->verifyInDatabase('comps', ['title' => 'CompTitle' , 'preview_type' => 'y' , 'preview_link' => 'https://www.youtube.com/embed/eL-rEbUmLdNU']);
    }

    /**
     * Tiek ievadīti korekti konkursa dati.
     */
    public function test_edit_with_valid_data()
    {
        $this->beUser();
        $this->Comp();
        $this->visit('userpanel/comps')
            ->click('Labot')
            ->type('CompTitle', 'title')
            ->select('preview_type', 'y')
            ->type( 'https://www.youtube.com/watch?v=eL-rEbUmLdNU' , 'preview_link')
            ->type( 'testaaa','description' )
            ->type('testaaa','rules')
            ->type('testaaa', 'prizes')
            ->type( 'testaaa', 'song_title')
            ->type( 'testaaa', 'stem_link' )
            ->press('Labot')
            ->see('Konkursa dati ');
        $this->verifyInDatabase('comps', ['title' => 'CompTitle' , 'preview_type' => 'y' , 'preview_link' => 'https://www.youtube.com/embed/eL-rEbUmLdNU']);

    }

} 