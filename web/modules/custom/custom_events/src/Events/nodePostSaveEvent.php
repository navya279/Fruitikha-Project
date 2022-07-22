<?php
namespace Drupal\custom_events\Events;

use Drupal\Component\EventDispatcher\Event;
use Drupal\user\UserInterface;
use Drupal\node\NodeInterface;

class nodePostSaveEvent extends Event {

    public $Entity;
    const EVENT_NAME = 'custom_node_post_save'; 

    public function __construct(NodeInterface $entity) {

      $this->Entity = $entity;

    }
}