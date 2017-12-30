<?php
/**
 *
 */

namespace Drupal\bt_image_gallery\Config;

use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Config\ConfigFactoryOverrideInterface;
use Drupal\Core\Config\ConfigFactory;

/**
 * Example configuration override.
 */
class ConfigImageGalleryOverride implements ConfigFactoryOverrideInterface {

    private $views_admin_media;
    private $views_full_admin_media;

    public function __construct(ConfigFactory $ConfigFactory)
    {
        $this->views_admin_media = $ConfigFactory->get('views.view.bt_admin_multimedia');
        $this->views_full_admin_media = $ConfigFactory->get('views.view.bt_full_admin_multimedia');
    }

    public function loadOverrides($names) {
        $overrides = array();

        $media_values = [
            'bt_image_gallery' => 'bt_image_gallery'
        ];
        // Add documents filter values to views.view.bt_admin_media view.
        if (in_array('views.view.bt_admin_media', $names)) {
            $views = $this->views_admin_media;
            $filter_values = $views->get('display.default.display_options.filters.bundle.value');
            $values = array_merge($filter_values,$media_values);
            $overrides['views.view.bt_admin_content']['display']['default']['display_options']['filters']['bundle']['value'] = $values;
        }
        // Add documents filter values to views.view.bt_full_admin_media view.
        if (in_array('views.view.bt_full_admin_media', $names)) {
            $views = $this->views_full_admin_media;
            $filter_values = $views->get('display.default.display_options.filters.type.value');
            $values = array_merge($filter_values,$media_values);
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