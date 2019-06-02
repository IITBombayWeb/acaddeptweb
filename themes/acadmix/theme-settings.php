<?php

use Drupal\Core\Template\RenderWrapper;
use Drupal\Core\Template\Attribute;
use Drupal\Component\Utility\Html;
use Drupal\Component\Utility\Xss;
use Drupal\search\Form\SearchBlockForm;
use Drupal\Component\Utility\SafeMarkup;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Theme\ThemeSettings;
use Drupal\image\Entity\ImageStyle;
use Drupal\system\Form\ThemeSettingsForm;
use Drupal\file\Entity\File;
use Drupal\Core\Url;
use Drupal\file\Plugin\Core\Entity\FileInterface;
use Drupal\Core\Config\ConfigFactoryInterface;

function acadmix_form_system_theme_settings_alter(&$form, &$form_state) {

  // $form['#attached']['library'][] = 'businessplus_lite/theme-settings';

  $form['acadmix_settings'] = array(
    '#type' => 'fieldset',
    '#title' => t('Acadmix custom theme Settings'),
    '#collapsible' => FALSE,
    '#collapsed' => FALSE,
  );

  $form['acadmix_settings']['tabs'] = array(
    '#type' => 'vertical_tabs',
    '#default_tab' => 'basic_tab',
  );

  $form['acadmix_settings']['social_tab']['social_icon'] = array(
    '#type' => 'details',
    '#title' => t('Social Media'),
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
    '#group' => 'tabs',
  );
  
  $form['acadmix_settings']['social_tab']['social_icon']['show_social_icon'] = array(
    '#type' => 'checkbox',
    '#title' => t('Show Social Icons'),
    '#default_value' => theme_get_setting('show_social_icon'),
    '#description'   => t("Show/Hide Social media links"),
  );
  
  $form['acadmix_settings']['social_tab']['social_icon']['facebook_url'] = array(
    '#type' => 'textfield',
    '#title' => t('Facebook URL'),
    '#default_value' => theme_get_setting('facebook_url'),
  );
  
  $form['acadmix_settings']['social_tab']['social_icon']['twitter_url'] = array(
    '#type' => 'textfield',
    '#title' => t('Twitter URL'),
    '#default_value' => theme_get_setting('twitter_url'),
  );
  
  $form['acadmix_settings']['social_tab']['social_icon']['linkedin_url'] = array(
    '#type' => 'textfield',
    '#title' => t('LinkedIn URL'),
    '#default_value' => theme_get_setting('linkedin_url'),
  );

  $form['acadmix_settings']['social_tab']['social_icon']['google_plus_url'] = array(
    '#type' => 'textfield',
    '#title' => t('Google PLus URL'),
    '#default_value' => theme_get_setting('google_plus_url'),
  );

  $form['acadmix_info'] = array(
    '#markup' => '<div class="messages messages--warning">Clear cache after making any changes in theme settings. <a href="../../config/development/performance">Click here to clear cache</a></div>'
  );

  $form['acadmix_settings']['faculty_header_tab']['faculty_header_bg'] = array(
    '#type' => 'details',
    '#title' => t('Faculty Header Background'),
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
    '#group' => 'tabs',
  );
  
  $form['acadmix_settings']['faculty_header_tab']['faculty_header_bg']['faculty_header_bg_file'] = array(
      '#type' => 'textfield',
      '#title' => t('Enter URL of the faculty page header background image file'),
      '#default_value' => theme_get_setting('faculty_header_bg_file'),
      '#description' => t('Enter a URL of the form (/sites/default/files/your-background.jpg). If the background image is bigger than the header area, it is clipped. If it\'s smaller than the header area, it is tiled to fill the header area. To remove the background image, blank this field and save the settings.'),
      '#size' => 40,
      '#maxlength' => 120,
  );

  $form['acadmix_settings']['faculty_header_tab']['faculty_header_bg']['faculty_header_bg'] = array(
    '#type' => 'file',
    '#title' => t('Upload faculty page header background image'),
    '#size' => 40,
    '#attributes' => array('enctype' => 'multipart/form-data'),
    '#description' => t('If you don\'t have direct access to the server, use this field to upload your header background image. Uploads limited to .png .gif .jpg .jpeg .apng .svg extensions'),
    '#element_validate' => array('faculty_header_bg_validate'),
  );

  $form['acadmix_settings']['event_header_tab']['event_header_bg'] = array(
    '#type' => 'details',
    '#title' => t('Event header Background'),
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
    '#group' => 'tabs',
  );
  

  $form['acadmix_settings']['event_header_tab']['event_header_bg']['event_header_bg_file'] = array(
      '#type' => 'textfield',
      '#title' => t('Enter URL of the event page header background image file'),
      '#default_value' => theme_get_setting('event_header_bg_file'),
      '#description' => t('Enter a URL of the form (/sites/default/files/your-background.jpg). If the background image is bigger than the header area, it is clipped. If it\'s smaller than the header area, it is tiled to fill the header area. To remove the background image, blank this field and save the settings.'),
      '#size' => 40,
      '#maxlength' => 120,
  );

  $form['acadmix_settings']['event_header_tab']['event_header_bg']['event_header_bg'] = array(
    '#type' => 'file',
    '#title' => t('Upload event page header background image'),
    '#size' => 40,
    '#attributes' => array('enctype' => 'multipart/form-data'),
    '#description' => t('If you don\'t have direct access to the server, use this field to upload your header background image. Uploads limited to .png .gif .jpg .jpeg .apng .svg extensions'),
    '#element_validate' => array('event_header_bg_validate'),
  );

  $form['acadmix_settings']['news_header_tab']['news_header_bg'] = array(
    '#type' => 'details',
    '#title' => t('News header Background'),
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
    '#group' => 'tabs',
  );

    $form['acadmix_settings']['news_header_tab']['news_header_bg']['news_header_bg_file'] = array(
        '#type' => 'textfield',
        '#title' => t('Enter URL of the news page header background image file'),
        '#default_value' => theme_get_setting('news_header_bg_file'),
        '#description' => t('Enter a URL of the form (/sites/default/files/your-background.jpg). If the background image is bigger than the header area, it is clipped. If it\'s smaller than the header area, it is tiled to fill the header area. To remove the background image, blank this field and save the settings.'),
        '#size' => 40,
        '#maxlength' => 120,
    );

    $form['acadmix_settings']['news_header_tab']['news_header_bg']['news_header_bg'] = array(
      '#type' => 'file',
      '#title' => t('Upload news page header background image'),
      '#size' => 40,
      '#attributes' => array('enctype' => 'multipart/form-data'),
      '#description' => t('If you don\'t have direct access to the server, use this field to upload your header background image. Uploads limited to .png .gif .jpg .jpeg .apng .svg extensions'),
      '#element_validate' => array('news_header_bg_validate'),
    );

}



function faculty_header_bg_validate($element, FormStateInterface $form_state) {
  global $base_url;

  $validators = array('file_validate_extensions' => array('png gif jpg jpeg apng svg'));
  $file = file_save_upload('faculty_header_bg', $validators, "public://", NULL, FILE_EXISTS_REPLACE);

  if (!empty($file)) {
    // change file's status from temporary to permanent and update file database
    if ((is_object($file[0]) == 1)) {
      $file[0]->status = FILE_STATUS_PERMANENT;
      $file[0]->save();
      $uri = $file[0]->getFileUri();
      $file_url = file_create_url($uri);
      $file_url = str_ireplace($base_url, '', $file_url);
      $form_state->setValue('faculty_header_bg_file', $file_url);
    }
 }
}


function event_header_bg_validate($element, FormStateInterface $form_state) {
  global $base_url;

  $validators = array('file_validate_extensions' => array('png gif jpg jpeg apng svg'));
  $file = file_save_upload('event_header_bg', $validators, "public://", NULL, FILE_EXISTS_REPLACE);

  if (!empty($file)) {
    // change file's status from temporary to permanent and update file database
    if ((is_object($file[0]) == 1)) {
      $file[0]->status = FILE_STATUS_PERMANENT;
      $file[0]->save();
      $uri = $file[0]->getFileUri();
      $file_url = file_create_url($uri);
      $file_url = str_ireplace($base_url, '', $file_url);
      $form_state->setValue('event_header_bg_file', $file_url);
    }
 }
}

function news_header_bg_validate($element, FormStateInterface $form_state) {
  global $base_url;

  $validators = array('file_validate_extensions' => array('png gif jpg jpeg apng svg'));
  $file = file_save_upload('news_header_bg', $validators, "public://", NULL, FILE_EXISTS_REPLACE);

  if (!empty($file)) {
    // change file's status from temporary to permanent and update file database
    if ((is_object($file[0]) == 1)) {
      $file[0]->status = FILE_STATUS_PERMANENT;
      $file[0]->save();
      $uri = $file[0]->getFileUri();
      $file_url = file_create_url($uri);
      $file_url = str_ireplace($base_url, '', $file_url);
      $form_state->setValue('news_header_bg_file', $file_url);
    }
 }
}