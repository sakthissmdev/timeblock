<?php

namespace Drupal\specbee_time;

use Drupal\Component\Datetime\TimeInterface;
use Drupal\Core\Datetime\DateFormatterInterface;

/**
 * Defines GetTime class.
 */
class GetTime {

  /**
   * A date time instance.
   *
   * @var \Drupal\Component\Datetime\TimeInterface
   */
  protected $time;

  /**
   * The date formatter.
   *
   * @var \Drupal\Core\Datetime\DateFormatterInterface
   */
  protected $dateFormatter;

  /**
   * Constructor.
   *
   * @param \Drupal\Core\Datetime\DateFormatterInterface $date_formatter.
   *  The date formatter.
   * @param Drupal\Component\Datetime\TimeInterface $time.
   *  A date time instance.
   */

  public function __construct(DateFormatterInterface $date_formatter, TimeInterface $time) {
    $this->dateFormatter = $date_formatter;
    $this->time = $time;
  }

 /**
  * get the time based on timezone.
  */
  public function getTime($timezone = 'Asia/Kolkata') {
    $current_time = $this->time->getCurrentTime();
    if ($current_time && $timezone) {
      $formatted_time = $this->dateFormatter->format($current_time, 'custom', 'h:i A', $timezone);
      $formatted_date = $this->dateFormatter->format($current_time, 'custom', 'l, j F Y', $timezone);
      $formatted_datetime = [$formatted_time,$formatted_date];
      return $formatted_datetime;
    }
    return '';
  }
}