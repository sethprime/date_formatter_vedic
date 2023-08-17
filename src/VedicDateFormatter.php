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
      //$now = new DrupalDateTime('now', $timezone, $datetime_settings);

      $date_string = $date->format('Y-m-d H:i:s P') . ' but Vedic!';

      return $date_string;
    }
}
