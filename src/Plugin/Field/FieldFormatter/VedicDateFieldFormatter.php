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
    $element = [];

    foreach ($items as $delta => $item) {
      // Render each element as markup.
      $element[$delta] = ['#markup' => $item->value];
    }

    return $element;
  }

}
