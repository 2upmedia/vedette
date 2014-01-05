<?php

/*
|--------------------------------------------------------------------------
| subscribe to Event Listeners
|--------------------------------------------------------------------------
*/

$subscriber = new Illuminate3\Vedette\Services\Subscribers\UserSubscriber;
Event::subscribe($subscriber);
/*
$subscriber = new Illuminate3\Vedette\Services\Subscribers\CoreSubscriber;
Event::subscribe($subscriber);

$subscriber = new Illuminate3\Vedette\Services\Subscribers\EloquentSubscriber;
Event::subscribe($subscriber);

$subscriber = new Illuminate3\Vedette\Services\Subscribers\PageSubscriber;
Event::subscribe($subscriber);

$subscriber = new Illuminate3\Vedette\Services\Subscribers\NavigationSubscriber;
Event::subscribe($subscriber);

$subscriber = new Illuminate3\Vedette\Services\Subscribers\UserSubscriber;
Event::subscribe($subscriber);
*/
