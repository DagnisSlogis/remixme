<?php
/**
 * Created by PhpStorm.
 * User: Dagnis
 * Date: 27.05.2015.
 * Time: 11:41
 */

class WinnerTest extends TestCase{

    /**
     * Konkurss un tā uzvarētāju paziņošana.
     *
     * @return mixed
     */
    private function Winners()
    {
        $user = $this->DummyUser();
        $comp = $this->SubmCompForUser($user);
        $voting = $this->VotingForACompShowned($comp);
        for($i=0;$i<4;$i++) {
            $this->SongsForAComp($voting);
        }
        $this->be($user);
        $this->visit('userpanel/judging')
            ->press('Vērtēt')
            ->select('place0' , '1')
            ->select('place1' , '2')
            ->select('place2' , '3')
            ->select('place3' , '0')
            ->press('Saglabāt')
            ->see('Konkurss');
        return $comp;
    }
    /**
     * Lietotājs izvēlās apskatīties konkursu uzvarētājus.
     */
    public function test_see_comp_winners_on_main_page()
    {
        $comp = $this->Winners();
        $this->visit('winners')
            ->see($comp->title);
    }

    /**
     * Konkursa rīkotājs izvēlās apskatīties konkursa uzvarētājus caur lietotāj panelī. Spiežot “Beigušies”
     */
    public function test_comp_author_wants_to_see_comp_winners_in_up()
    {
        $comp = $this->Winners();
        $this->visit('userpanel/comps/ended')
            ->see($comp->title);
    }

    /**
     * administrators izvēlās apskatīties konkursa uzvarētājus caur lietotāj panelī. Spiežot “Beigušies”
     */
    public function test_admin_wants_to_see_comp_winners_in_ap()
    {
        $comp = $this->Winners();
        $this->beAdmin();
        $this->visit('/adminpanel/comps/hasended')
            ->see($comp->title);
    }

    /**
     * Viesis mēģina izsaukt kādu no šim funkcijām
     */
    public function test_guest_wants_to_see_winners()
    {
        $this->visit('winners')
            ->onPage('auth/login');
        $this->visit('userpanel/comps/ended')
            ->onPage('auth/login');
        $this->visit('/adminpanel/comps/hasended')
            ->onPage('auth/login');
    }

}

