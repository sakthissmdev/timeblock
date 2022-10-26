<?php

/**
 * @file
 * Contains Drupal\specbee_time\Form\TimerSettingForm.
 */

namespace Drupal\specbee_time\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class TimerSettingForm.
 *
 * @package Drupal\specbee_time\Form
 */
class TimerSettingForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'timer.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'timerconfig_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('timer.settings');
    $timezones = [
        'America/Chicago' => $this->t('America/Chicago'),
        'America/New_York' => $this->t('America/New_York'),
        'Asia/Tokyo' => $this->t('Asia/Tokyo'),
        'Asia/Dubai' => $this->t('Asia/Dubai'),
        'Asia/Kolkata' => $this->t('Asia/Kolkata'),
        'Europe/Amsterdam' => $this->t('Europe/Amsterdam'),
        'Europe/Oslo' => $this->t('Europe/Oslo'),
        'Europe/London' => $this->t('Europe/London'),
    ];

    $form['country'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Country'),
        '#required' => TRUE,
        '#default_value' => $config->get('country')
    ];

    $form['city'] = [
        '#type' => 'textfield',
        '#title' => $this->t('City'),
        '#required' => TRUE,
        '#default_value' => $config->get('city')
    ];

    $form['timezone']=[
        '#type' => 'select',
        '#options' => $timezones,
        '#title' => $this->t('Timezone'),
        '#required' => TRUE,
        '#default_value' => $config->get('timezone')
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);
    
    $config = $this->config('timer.settings');
    foreach ($form_state->getValues() as $key => $value) {
        $config->set($key,$value);
    }
    $config->save();
  }

}
