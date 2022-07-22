<?php
namespace Drupal\fruitikha_block\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;


class CustomSiteSettings extends ConfigFormBase {
  
    public function getFormId() {
        return 'fruitikha_site_settings';
    }
     
    const SETTINGS = 'fruitikha_block.settings';
    
    protected function getEditableConfigNames(){
      return [ static::SETTINGS ];
    }
    public function buildForm(array $form,FormStateInterface $form_state) {

      $config = $this->config(static::SETTINGS);
      //dump($config);
      $form['about_company'] = [
          "#type" =>'textfield',
          "#title" => $this->t('About Company'),
          "#required" => TRUE,
          "#default_value" => $config->get('about_company'),
      ];
      $form['address'] = [
        "#type" =>'textfield',
        "#title" => $this->t('Address'),
        "#required" => TRUE,
        "#default_value" => $config->get('address'),
    ];
    $form['subscribe'] = [
        "#type" =>'textfield',
        "#title" => $this->t('Subscribe'),
        "#required" => TRUE,
        "#default_value" => $config->get('subscribe'),
    ];
    $form['facebook_links'] = [
        "#type" =>'textfield',
        "#title" => $this->t('FaceBook Link'),
        "#default_value" =>$config->get('facebook_links'),
    ];
    $form['twitter_links'] = [
        "#type" =>'textfield',
        "#title" => $this->t('Twitter Link'),
        "#default_value" =>$config->get('twitter_links'),
    ];
    $form['insta_links'] = [
        "#type" =>'textfield',
        "#title" => $this->t('Instagram Link'),
        "#default_value" =>$config->get('insta_links'),
    ];

      return parent::buildForm($form,$form_state);
    }
    public function submitForm(array &$form,FormStateInterface $form_state) {

      $configuration = $this->configFactory->getEditable(static::SETTINGS);
      //dump($form_state->getValues());exit;
      $configuration->set('about_company',$form_state->getValue('about_company'));
      $configuration->set('address',$form_state->getValue('address'));
      $configuration->set('subscribe',$form_state->getValue('subscribe'));
      $configuration->set('facebook_links',$form_state->getValue('facebook_links'));
      $configuration->set('twitter_links',$form_state->getValue('twitter_links'));
      $configuration->set('insta_links',$form_state->getValue('insta_links'));
      $configuration->save();
      return parent::submitForm($form,$form_state);

    }
}