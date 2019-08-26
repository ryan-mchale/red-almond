<?php
namespace RedAlmond\Theme\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\Store;

class DesignThemeConfig implements DataPatchInterface {
    const THEME_NAME = 'RedAlmond/site';

    /**
     * @var \Magento\Theme\Model\ResourceModel\Theme\Collection
     */
    private $themeCollection;

    /**
     * @var \Magento\Theme\Model\Config
     */
    private $config;

    public function __construct(
        \Magento\Theme\Model\ResourceModel\Theme\CollectionFactory $themeCollection,
        \Magento\Theme\Model\Config $config
    ) {
        $this->themeCollection = $themeCollection->create();
        $this->config          = $config;
    }

    /**
     * {@inheritDoc}
     */
    public function apply() {
        $theme = $this->themeCollection->loadRegisteredThemes()->addFieldToFilter('code', self::THEME_NAME)->getFirstItem();

        $this->config->assignToStore($theme, [Store::DEFAULT_STORE_ID], ScopeConfigInterface::SCOPE_TYPE_DEFAULT);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getAliases() {
        return [];
    }

    /**
     * {@inheritDoc}
     */
    public static function getDependencies() {
        return [
            \Magento\Theme\Setup\Patch\Data\RegisterThemes::class,
        ];
    }
}
