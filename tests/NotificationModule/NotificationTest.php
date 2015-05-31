<?php
/**
 * Created by PhpStorm.
 * User: Dagnis
 * Date: 27.05.2015.
 * Time: 11:52
 */

class NotificationTest extends TestCase {

    /**
     * Paziņojumus
     *
     * @return mixed
     */
    private function createNotification()
    {
        $user = $this->DummyUser();
        $comp = $this->CompForUser($user);
        $this->VotingForAComp($comp);
        $this->be($user);
        $this->visit('/')
            ->type('Testa dziesma','title')
            ->type('dadad','link')
            ->press('Iesūtit')
            ->see('pievienota');
        return $comp;
    }

    /**
     * Lietotājs izvēlās apskatīties savus saņemtos paziņojumus
     */
    public function test_user_wants_to_see_his_notif()
    {
        $comp = $this->createNotification();
        $this->visit('/userpanel/notification')
            ->see($comp->title)
            ->onPage('userpanel/notification');
    }

    /**
     * Lietotājs atver paziņojumu logu, kad ir jauns, neapskatīts paziņojums
     */
    public function test_user_wants_to_see_his_notif_onNotifPopup()
    {
        $comp = $this->createNotification();
        $this->visit('/')
            ->see($comp->title)
            ->onPage('/');
    }
} 