<?php

namespace Drupal\date_formatter_vedic\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\date_formatter_vedic\VedicDateFormatter;
use Symfony\Component\DependencyInjection\ContainerInterface;

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
class VedicDateFieldFormatter extends FormatterBase implements ContainerFactoryPluginInterface {

  /**
   * The date formatter.
   *
   * @var \Drupal\date_formatter_vedic\VedicDateFormatter
   */
  protected $vedicDateFormatter;

  /**
   * Constructs a TimestampAgoFormatter object.
   *
   * @param string $plugin_id
   *   The plugin_id for the formatter.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Field\FieldDefinitionInterface $field_definition
   *   The defninition of the field to which the formatter is associated.
   * @param array $settings
   *   The formatter settings.
   * @param string $label
   *   The formatter label display setting.
   * @param string $view_mode
   *   The view mode.
   * @param array $third_party_settings
   *   Any third party settings.
   * @param \Drupal\date_formatter_vedic\VedicDateFormatter $date_formatter
   *   The date formatter.
   */
  public function __construct($plugin_id, $plugin_definition, FieldDefinitionInterface $field_definition, array $settings, $label, $view_mode, array $third_party_settings, VedicDateFormatter $date_formatter) {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $label, $view_mode, $third_party_settings);
    $this->vedicDateFormatter = $date_formatter;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    // @see \Drupal\Core\Field\FormatterPluginManager::createInstance().
    return new static(
      $plugin_id,
      $plugin_definition,
      $configuration['field_definition'],
      $configuration['settings'],
      $configuration['label'],
      $configuration['view_mode'],
      $configuration['third_party_settings'],
      $container->get('vedic_date_formatter.formatter')
    );
  }

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

    $field_type = $items->getFieldDefinition()->getType();
    foreach ($items as $delta => $item) {
      if ($field_type == 'datetime') {
        $timestamp = $item->date->getTimestamp();
      }
      else {
        $timestamp = $item->getValue()['value'];
      }

      // Render each element as markup.
      if (!is_null($this->vedicDateFormatter)) {
        $elements[$delta] = [
          '#markup' => $this->vedicDateFormatter->formatTimestamp($timestamp),
        ];
      }
      else {
        $elements[$delta] = [
          '#markup' => print_r($this->vedicDateFormatter, TRUE),
        ];

      }
    }

    return $elements;
  }
}
