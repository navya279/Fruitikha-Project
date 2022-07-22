<?php
namespace Drupal\custom_events\EventSubscriber;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\Core\Config\ConfigCrudEvent;
use Drupal\Core\Config\ConfigEvents;

class ConfigMessage implements EventSubscriberInterface {

   /**
   * {@inheritdoc}
   *
   * @return array
   *   The event names to listen for, and the methods that should be executed.
   */
    public static function getSubscribedEvents() {
        return [
            ConfigEvents::SAVE => 'CustomConfigSave'
          ];
    }

    public function CustomConfigSave(ConfigCrudEvent  $events) {
      $config = $events->getConfig();
     \Drupal::messenger()->addStatus('testing events ---- Saved config: ' . $config->getName());
    }

}