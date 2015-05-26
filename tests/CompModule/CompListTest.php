<?php
/**
 * Created by PhpStorm.
 * User: Dagnis
 * Date: 22.05.2015.
 * Time: 22:10
 */

class CompListTest extends TestCase{
    /**
     * Tiek izvēlēts apskatīties jaunākos konkursus.
     */
    public function test_see_newest_comps()
    {
        $comp = $this->TestComp();
        $this->visit('/')
            ->see($comp->title)
            ->onPage('/');
    }

    /**
     * Tiek izvēlēts apskatīties populārākos konkursus.
     */
    public function test_see_popular_comps()
    {
        $comp = $this->TestComp();
        $this->visit('/comps/popular')
            ->see($comp->title)
            ->onPage('/comps/popular');
    }

    /**
     * Tiek izvēlēts apskatīties konkursus, kuriem drīz noslēgsies 1. posms.
     */
    public function test_see_endingsoon_comps()
    {
        $comp = $this->TestComp();
        $this->visit('/comps/endsoon')
            ->see($comp->title)
            ->onPage('/comps/endsoon');
    }
} 