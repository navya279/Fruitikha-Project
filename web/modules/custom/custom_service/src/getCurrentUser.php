<?php
namespace Drupal\custom_service;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;

class getCurrentUser {

    protected $currentUser;
    protected $EntityType;

    public function __construct(AccountProxyInterface $currentUser,EntityTypeManagerInterface $entity_type_manager) {
      $this->currentUser = $currentUser;
      $this->EntityType = $entity_type_manager;
    }

    public function getData(){
        $currentUserId = $this->currentUser->id();
        //$user_entity = \Drupal::entityTypeManager()->getStorage('user')->load($currentUserId);
        $user_entity = $this->EntityType->getStorage('user')->load($currentUserId);
        //dump($user_entity);exit;
        return $user_entity;
    }
}