<?php

namespace Drupal\date_formatter_vedic\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the vedic date formatter.
 *
 * @FieldFormatter(
 *   id = "date_formatter_vedic",
 *   label = @Translation("Vedic date"),
 *   field_types = {
 *     "datetime",
 *     "timestamp",
 *     "created",
 *     "changed",
 *     "published_at",
 *   }
 * )
 */
class VedicDateFieldFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    $summary[] = $this->t('Displays the date_formatter_vedic string.');
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    $field_type = $items=>getFieldDefinition()->getType();
    foreach ($items as $delta => $item) {
      if ($field_type == 'datetime') {
        $timestamp = $item->date->getTimestamp();
      }
      else {
        $timestamp = $item->value();
      }

      // Render each element as markup.
      $elements[$delta] = [
        '#markup' => $this->vedicDateFormatter->formatTimestamp($timestamp),
      ];
    }

    return $elements;
  }
}
