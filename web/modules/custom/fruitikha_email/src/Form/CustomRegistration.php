<?php
namespace Drupal\fruitikha_email\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Messenger\Messenger;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Mail\MailManager;

class CustomRegistration extends FormBase {

    protected $messenger;
    protected $mail_manager;

    public function __construct(Messenger $messenger,MailManager $mail) {
      $this->messenger = $messenger;
      $this->mail_manager = $mail;
    }

    public static function create(ContainerInterface $container) {
        return new static(
            $container->get('messenger'),
            $container->get('plugin.manager.mail'),
        );
    }

    public function getFormId() {
        return 'custom_registration';
    }
    public function buildForm(array $form,FormStateInterface $form_state) {
        $form['name'] = [
              "#type" => "textfield",
              "#title" => "Name",
              "#required" => TRUE
        ];
        $form['email'] = [
            "#type" => "email",
            "#title" => "Email",
            "#required" => TRUE
      ];
      $form['action']['submit'] = [
        "#type" => "submit",
        "#value" => "Submit",
        "#prefix" => "<div>",
        "#suffix" => "</div>",
     ];
     return $form;

    }

    /**
     * sending email in submit form
     */
    public function submitForm(array &$form,FormStateInterface $form_state) {

        //$mailManager = \Drupal::service('plugin.manager.mail');//added dependency injection here
        $module = 'fruitikha_email';//module name
        $key = 'general_mail';// A key to identify the email sent. The final message ID for email altering will be {$module}_{$key}.
        $to = "mail@mail.com";
        $params['message'] = $form_state->getValues();
        $params['subject'] = "Custom Form Values";
        $langcode = \Drupal::currentUser()->getPreferredLangcode();
        $send = true; //If TRUE, call an implementation of \Drupal\Core\Mail\MailInterface->mail() to deliver the message, and store the result in $message['result']. Modules implementing hook_mail_alter() may cancel sending by setting $message['send'] to FALSE.
        // NULL - string|null $reply: Optional email address to be used to answer.
        $result = $this->mail_manager->mail($module, $key, $to, $langcode, $params, NULL, $send);
        //dump($result);exit;
        if ($result['result'] !== true) {
            $this->messenger->addError(t('There was a problem sending your message and it was not sent.'), 'error');
        }
        else {
            $this->messenger->addMessage(t('Your message has been sent.'));
        }      
        // \Drupal::messenger()->addMessage(t('Success'));
    }
}