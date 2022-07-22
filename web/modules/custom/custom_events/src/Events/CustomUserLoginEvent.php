<?php
namespace Drupal\custom_events\Events;

use Drupal\Component\EventDispatcher\Event;
use Drupal\user\UserInterface;

class CustomUserLoginEvent extends Event {

    const EVENT_NAME = 'custom_user_login_details'; 
    public $user_account;

    public function __construct(UserInterface $account) {
      $this->user_account = $account;
    }
}