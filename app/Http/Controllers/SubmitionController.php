<?php namespace App\Http\Controllers;

use App\Comp;
use App\Http\Requests;
use App\Submition;
use Auth;
use App\Votable;
use App\Http\Controllers\Controller;

use App\Http\Requests\AddSubmitionRequest;
use Illuminate\Http\Request;

class SubmitionController extends Controller {

    public function store($id , AddSubmitionRequest $request )
    {
        $comp = Comp::whereId($id)->first();
        $this->checkEntrys($id);
            $submition =  new Submition;
            $submition->title = $request['title'];
            $submition->link = $request['link'];
            $submition->comp_id = $id;
            $submition->user_id = Auth::user()->id;
            $submition->save();
        if($comp->voting_type == 'd')
        {
            $this->votable($submition);
        }
        \Session::flash('success_message', 'Dziesma veiksmīgi pievienota konkursam!');
        return redirect()->back();
    }

    /**
     * Sagatavo iesūtīto remiksu balsošanai
     * @param $submition
     */
    private function votable($submition)
    {
        $slugifedTitle = str_replace(' ', '-', $submition->title);
        $votable = new Votable;
        $votable->slug = $submition->id.$slugifedTitle;
        $votable->submition_id = $submition->id;
        $votable->save();

    }

    /**
     * Viens lietotājs vienam konkursam var iesniegt tikai vienu remiksu
     *
     * @param $id
     */
    private function checkEntrys($id)
    {
        $HaveEntered = Submition::whereUserId(Auth::user()->id)
            ->whereCompId($id)
            ->whereStatus('v')
            ->first();
        if($HaveEntered){
            $HaveEntered->status = 'd';
            $HaveEntered->save();
            $votable = Votable::whereSubmitionId($HaveEntered->id);
            $votable->delete();
        }
    }

}
