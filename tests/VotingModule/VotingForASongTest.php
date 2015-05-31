<?php
/**
 * Created by PhpStorm.
 * User: Dagnis
 * Date: 27.05.2015.
 * Time: 10:48
 */

class VotingForASongTest extends TestCase {

    /**
     * Lietotājs izvēlās apskatīt jaunākos balsojamos r.k.
     */
    public function test_user_wants_to_see_votable_comps_in_main_page()
    {
        $user = $this->DummyUser();
        $comp = $this->UserCanVoteComForUser($user);
        $voting = $this->VotingForACompShowned($comp);
        $this->be($user);
        $song = $this->SongsForAComp($voting);
        $this->visit('voting')
            ->see($song->title);
    }

    /**
     * Lietotājs izvēlās apskatīt populārākos balsojamos r.k.
     */
    public function test_user_wants_to_see_votable_comps_in_popular_view()
    {
        $user = $this->DummyUser();
        $comp = $this->UserCanVoteComForUser($user);
        $voting = $this->VotingForACompShowned($comp);
        $this->be($user);
        $song = $this->SongsForAComp($voting);
        $this->visit('voting/popular')
            ->see($song->title);
    }

    /**
     * Lietotājs izvēlās apskatīt balsojamos r.k., kuru balsošanas laiks drīz beigsies
     */
    public function test_user_want_to_see_votable_comps_in_ending_soon_view()
    {
        $user = $this->DummyUser();
        $comp = $this->UserCanVoteComForUser($user);
        $voting = $this->VotingForACompShowned($comp);
        $this->be($user);
        $song = $this->SongsForAComp($voting);
        $this->visit('voting/endsoon')
            ->see($song->title);
    }

    /**
     * Izvēlās apskatīties dziesmas par kurām var balsot konkursā.
     */
    public function test_user_wants_to_see_votable_songs_in_the_comp()
    {
        $user = $this->DummyUser();
        $comp = $this->UserCanVoteComForUser($user);
        $voting = $this->VotingForACompShowned($comp);
        $this->be($user);
        for($i =  0 ; $i<5 ; $i++) {
            $this->SongsForAComp($voting);
        }
        $this->visit('comp/voting/'.$comp->id);
    }

    /**
     * Balso par dziesmu, par kuru vēl nav balsots
     */
    public function test_user_votes_for_a_song()
    {
        $user = $this->DummyUser();
        $comp = $this->UserCanVoteComForUser($user);
        $voting = $this->VotingForACompShowned($comp);
        $this->be($user);
        $song = $this->SongsForAComp($voting);
        $this->visit('voting')
            ->press('Balsot');
        $this->verifyInDatabase('votes', ['submition_id' => $song->id , 'user_id' => $user->id]);
    }

    /**
     * Balso par dziesmu, par kuru ir jau balsojis
     */
    public function test_user_votes_for_a_song_again()
    {
        $this->test_user_votes_for_a_song();
        $this->visit('voting')
            ->press('Balsot')
            ->see('esat balsojis');
    }

    /**
     * Viesis mēģina izsaukt, jebkuru no šim darbībām.
     */
    public function test_guest_wants_to_vote()
    {
        $this->visit('voting')
            ->onPage('auth/login');
    }
} 