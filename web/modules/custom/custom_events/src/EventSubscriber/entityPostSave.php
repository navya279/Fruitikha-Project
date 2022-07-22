<?php
namespace Drupal\custom_events\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\custom_events\Events\nodePostSaveEvent;

class entityPostSave implements EventSubscriberInterface {

    public static function getSubscribedEvents() {
        return [
            nodePostSaveEvent::EVENT_NAME => 'nodePostSave'
          ];
    }
    public function nodePostSave(nodePostSaveEvent $event) {
        
        //$user = $event->user_account;
        \Drupal::messenger()->addStatus("Congradulations....This node " .$event->Entity->title->value." created successfully. ");
    }
}