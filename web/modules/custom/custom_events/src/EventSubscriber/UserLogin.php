<?php
namespace Drupal\custom_events\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\custom_events\Events\CustomUserLoginEvent;

class UserLogin implements EventSubscriberInterface {

     /**
   * {@inheritdoc}
   *
   * @return array
   *   The event names to listen for, and the methods that should be executed.
   */
  public static function getSubscribedEvents() {
    return [
        CustomUserLoginEvent::EVENT_NAME => 'userLoginMessage'
      ];
  }

  public function userLoginMessage(CustomUserLoginEvent  $event){
   
    $user = $event->user_account;
    $entity = \Drupal::entityTypeManager()->getStorage('node');
    $entity_ids = $entity->getQuery()
      ->condition('uid',$user->id())
      ->condition('status',1)
      ->sort('created','DESC')
      ->execute();
    $nodes = $entity->loadMultiple($entity_ids);
    \Drupal::messenger()->addStatus("User Created Nodes are : " );
    foreach($nodes as $node){
      \Drupal::messenger()->addStatus(' - ' .$node->title->value);
    }
    
    \Drupal::messenger()->addStatus("Hai,welcome ".$user->name->value ." This account created on ".date('d/m/Y', $user->created->value));
  }
}