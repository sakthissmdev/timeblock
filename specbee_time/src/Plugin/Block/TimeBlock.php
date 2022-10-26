<?php

namespace Drupal\specbee_time\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Config\ConfigFactory;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\specbee_time\GetTime;

/**
 * Provides a Block to display time.
 *
 * @Block(
 *   id = "specbee_time_block",
 *   admin_label = @Translation("Specbee Time Block"),
 *   category = @Translation("Specbee"),
 * )
 */
class TimeBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The config factory.
   *
   * @var Drupal\Core\Config\ConfigFactory.
   */
  protected $configFactory;

  /**
   * The GetTime service.
   *
   * @var Drupal\display_time\GetTime.
   */
  protected $time;

  /**
   * Constructor.
   * 
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   * @param Drupal\Core\Config\ConfigFactory $config_factory.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, ConfigFactory $config_factory, GetTime $time) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->configFactory = $config_factory;
    $this->time = $time;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('config.factory'),
      $container->get('time.get_time')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
      $config = $this->configFactory->get('timer.settings');
      $timezone_selected = !empty($config->get('timezone')) ? $config->get('timezone') : '';
      $country = !empty($config->get('country')) ? $config->get('country') : '';
      $city = !empty($config->get('city')) ? $config->get('city') : '';
      // Calling service
      if ($timezone_selected) {
        $output_datetime = $this->time->getTime($timezone_selected);
        $output_time = $output_datetime[0];
        $output_date = $output_datetime[1];
      }

      return [
        '#theme' => 'specbee_time',
        '#attached' => [
          'drupalSettings' => [
            'timezone' => $timezone_selected,
          ],
          'library' => [
            'specbee_time/specbee_time_lib'
          ],
        ],
        '#country' => $country,
        '#city' => $city,
        '#output_time' => $output_time,
        '#output_date' => $output_date,
        '#timezone' => $timezone_selected,
        '#cache' => [
          'max-age' => 60,
        ],
    ];}
}
