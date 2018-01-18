<?php

namespace Drupal\bt_image_gallery\Config;

use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Config\ConfigFactoryOverrideInterface;
use Drupal\Core\Config\ConfigFactory;

/**
 * Example configuration override.
 */
class ConfigImageGalleryOverride implements ConfigFactoryOverrideInterface {

  private $viewsAdminMedia;
  private $viewsFullAdminMedia;

  /**
   * {@inheritdoc}
   */
  public function __construct(ConfigFactory $configFactory) {
    $this->viewsAdminMedia = $configFactory->get('views.view.bt_admin_multimedia');
    $this->viewsFullAdminMedia = $configFactory->get('views.view.bt_full_admin_multimedia');
  }

  /**
   * {@inheritdoc}
   */
  public function loadOverrides($names) {
    $overrides = array();

    $media_values = [
      'bt_image_gallery' => 'bt_image_gallery',
    ];
    // Add documents filter values to views.view.bt_admin_media view.
    if (in_array('views.view.bt_admin_media', $names)) {
      $views = $this->viewsAdminMedia;
      $filter_values = $views->get('display.default.display_options.filters.bundle.value');
      $values = array_merge($filter_values, $media_values);
      $overrides['views.view.bt_admin_content']['display']['default']['display_options']['filters']['bundle']['value'] = $values;
    }
    // Add documents filter values to views.view.bt_full_admin_media view.
    if (in_array('views.view.bt_full_admin_media', $names)) {
      $views = $this->viewsFullAdminMedia;
      $filter_values = $views->get('display.default.display_options.filters.type.value');
      $values = array_merge($filter_values, $media_values);
      $overrides['views.view.bt_full_admin_content']['display']['default']['display_options']['filters']['bundle']['value'] = $values;
    }

    return $overrides;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheSuffix() {
    return 'ConfigImageGalleryOverride';
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheableMetadata($name) {
    return new CacheableMetadata();
  }

  /**
   * {@inheritdoc}
   */
  public function createConfigObject($name, $collection = StorageInterface::DEFAULT_COLLECTION) {
    return NULL;
  }

}
