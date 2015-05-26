<?php
/**
 * Created by PhpStorm.
 * User: Dagnis
 * Date: 22.05.2015.
 * Time: 21:25
 */

class CompSearchingTest extends TestCase {

    /**
     * Meklēšanas logā tiek ierakstīts eksistējoša konkursa nosaukums/dziesmas nosaukums vai žanrs.
     */
    public function test_searching_for_an_existing_comp()
    {
        $comp = $this->TestComp();
        $this->visit('/')
            ->type( $comp->title, 's')
            ->press('Meklēt')
            ->see($comp->title);
    }

    /**
     * Meklēšanas logā tiek ierakstīta meklējamā frāze, kas nav pilns nosaukums.
     */
    public function test_searching_for_keyword()
    {
        $comp = $this->TestComp();
        $search = substr($comp->song_title, 1 , 3);
        $this->visit('/')
            ->type( $search, 's')
            ->press('Meklēt')
            ->see($search)
            ->onPage('/comps/find?s='.$search);
    }
} 