<?php 
namespace Drupal\fruitikha_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;
/**
 * @Block(
 *   id = "logo_slider_block",
 *   admin_label = @Translation("Logo Block Base")
 * )
 */
class LogoSliderBlock extends BlockBase {

    public function blockForm( $form,FormStateInterface $form_state) {

      $form = parent::blockForm($form,$form_state);
      $config = $this->getConfiguration();
      //dump($config['company_logos']);exit;
      //multiple image upload
      $form['company_logo'] = [
          "#type" => 'managed_file',
          "#title" => t('Attach company logo'),
          '#required' => TRUE,
          '#upload_location' => 'public://company_images',
          '#upload_validators' => [
              'file_validate_extensions' => $this->getAllowedFileExtensions()
          ],
          '#multiple' => TRUE,
          '#default_value' => $config['company_logos']
      ];
      return $form;
    }
     
    public function blockSubmit($form,FormStateInterface $form_state) {
      parent::blockSubmit($form,$form_state);
      $this->configuration['company_logos'] = $form_state->getValue('company_logo') ;
      foreach($this->configuration['company_logos'] as $image) {
       //save image permanent
        $file = File::load($image);
        $file->setPermanent();
        $file->save();
      }
    }

    public function build() {
        //get configuration value
        $config = $this->getConfiguration();
        $images = $config['company_logos'];
        //dump($config['company_logos']);exit;
       // $file = \Drupal\file\Entity\File::load($image);
       //$file->getFileUri()
        $result =[];
        foreach($images as $logos) {
            $file = File::load($logos);
            // dump($file);
            if($file) {
              //for render image as renderable array
              $result['logos'][] = [
                  "#theme" => 'image',
                  "#uri" => $file->getFileUri(),
              ];
            }
        }
        return $result;
    }
    private function getAllowedFileExtensions(){
        return array('jpg jpeg gif png');
      }
}