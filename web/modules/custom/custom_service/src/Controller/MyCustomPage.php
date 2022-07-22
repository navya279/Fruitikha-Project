<?php
namespace Drupal\custom_service\Controller;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\custom_service\getCurrentUser;

class MyCustomPage extends ControllerBase {

    protected $CurrentUser;

    public static function create(ContainerInterface $container){
      return new static(
        $container->get('custom.current_user')
      );
    }

    public function __construct(getCurrentUser $current_user){
      $this->CurrentUser = $current_user;
    }

    public function page() {

        $data = $this->CurrentUser->getData();
        $name = $data->name->value;
        $mail = $data->mail->value;

        return [
            "#markup" => "My custom page for current user -- ". $name ." -- ". $mail
        ];
    }
}