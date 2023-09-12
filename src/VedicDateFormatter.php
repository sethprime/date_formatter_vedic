<?php

namespace Drupal\date_formatter_vedic;

use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Language\LanguageManagerInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * Services for formatting timestamps into Vedic time.
 */
class VedicDateFormatter {

    use StringTranslationTrait;

    /**
     * Language manager for retrieving default langcode when none is specified.
     *
     * @var \Drupal\Core\LanguageManagerInterface
     */
    protected $languageManager;

    /**
     * Constructor.
     *
     * @param \Drupal\Core\Language\LanguageManagerInterface $language_manager
     *  The language manager.
     */
    public function __construct(LanguageManagerInterface $language_manager) {
      $this->languageManager = $language_manager;
    }

    /**
     * Format a timestamp to Vedic date format.
     *
     * @param int $timestamp
     *   The timestamp to convert.
     * @param mixed $timezone
     *   \DateTimeZone object, time zone string or NULL. NULL uses the
     *   default system time zone. Defaults to NULL.
     * @param string $langcode
     *   The language code.
     * @param string $fieldtype
     *   Type of field. Example, smartdate.
     *
     * @return string
     *   The formatted date string.
     */
    public function formatTimestamp($timestamp, array $options = [], $timezone = NULL, $langcode = NULL, $fieldtype = NULL) {
      if (empty($options)) {
        // Haven't implemented config options yet.
        // $options = $this->getOptions();
      }

      if (empty($langcode)) {
        $langcode = $this->languageManager->getCurrentLanguage()->getId();
      }

      // If no timezone is specified use the user's if available, or the site
      // or system default.
      if (empty($timezone)) {
        $timezone = date_default_timezone_get();
      }

      // Create a DrupalDateTime object from the timestamp and timezone.
      $datetime_settings = [
        'langcode' => $langcode,
      ];
      
      $date_string = '';
      $format_date = '';

      $date = DrupalDateTime::createFromTimestamp($timestamp, $timezone, $datetime_settings);
      // I don't think we're using this $now yet.
      //$now = new DrupalDateTime('now', $timezone, $datetime_settings);

      // Get the DateTimeZone object.
      $timezone = $date->getTimezone();

      // Get the latitude and longitude of the timezone.
      $timezone_location = $timezone->getLocation();

      // Get the sunrise time.
      $sun_info = date_sun_info($date->getTimestamp(), $timezone_location['latitude'], $timezone_location['longitude']);


      $date_string = '';

      $day_duration = $date->getTimestamp() - $sun_info['sunrise'];
      $muhurta_number = floor($day_duration / 60 / 48);

      $muhurtas = [
        'Cryer',
        'Serpent',
        'Friend',
        'Father',
        'Bright',
        'Boar',
        'Heavenly Lights in the Universe',
        'Insight',
        'Goat/Charioteer-Face',
        'Many Offerings',
        'Possessed of Chariot',
        'Night Maker',
        'All-Enveloping Night Sky',
        'Possessed of Nobility',
        'Stake',
        'Lord who Lifted the Mount (Krishna)',
        'Unborn Foot',
        'Serpent at the Bottom',
        'Nourishment',
        'Horsement',
        'Restrainer',
        'Ignition',
        'Distributor',
        'Ornament',
        'Limitless',
        'Immortal',
        'All Pervading',
        'Resounding Light',
        'Universe',
        'Ocean',
      ];

      $date_string .= $muhurtas[$muhurta_number];

      return $date_string;
    }
}
