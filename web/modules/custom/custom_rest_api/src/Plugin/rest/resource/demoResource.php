<?php
namespace Drupal\custom_rest_api\Plugin\rest\resource;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Psr\Log\LoggerInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Component\Serialization\Json;
/**
 * In order to configure our endpoint we will be utilizing Plugin annotations
 * Plugins are piece of functionality.
 * @RestResource(
 * id = "demo_resource",
 * label = @Translation("Demo Resource"),
 * uri_paths= {
 *   "canonical" = "/custom_rest_api/demo_resource",
 *   "create" = "/custom_rest_api/create_resource"
 * }
 * )
 */
class demoResource extends ResourceBase {

   
    protected $EntityTypeManager;

    public function __construct($configuration, $plugin_id, $plugin_definition, array $serializer_formats, LoggerInterface $logger,EntityTypeManagerInterface $entity_type_manager) {
        parent::__construct($configuration, $plugin_id, $plugin_definition,$serializer_formats, $logger,); 
        $this->EntityTypeManager = $entity_type_manager;
    }

    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
        return new static(
             $configuration, 
             $plugin_id, 
             $plugin_definition,
             $container->getParameter('serializer.formats'),
             $container->get('logger.factory')->get('rest'), 
             $container->get('entity_type.manager')
        );
    }
  
    public function get(){
        //$response = ['message' => "Haiii Navya"];
        // $userStorage = \Drupal::entityTypeManager()->getStorage('user');
        //$query = $userStorage->getQuery();
        $userStorage = $this->EntityTypeManager->getStorage('user');
        $query = $userStorage->getQuery();
        $uids = $query
        ->condition('status', '1')
        ->execute();
         $users = $userStorage->loadMultiple($uids);
        $user_array = [];
        foreach($users as $key => $user) {
          $user_array[$key]['id'] = $user->uid->value;
          $user_array[$key]['name'] = $user->get('name')->value;
          $user_array[$key]['mail'] = $user->mail->value;
        }
        return new ResourceResponse($user_array);
    }
    public function post(Request $request) {

        $params = Json::decode($request->getContent());
        $uid = $params['user_id'];
        $users =  $this->EntityTypeManager ->getStorage('user')->loadByProperties([ 'uid' => $uid,]);
        $user_array = [];
        foreach($users as $key => $user) {
            $user_array[$key]['id'] = $user->uid->value;
            $user_array[$key]['name'] = $user->get('name')->value;
            $user_array[$key]['mail'] = $user->mail->value;
        }
        return new ResourceResponse($user_array);
    }
}