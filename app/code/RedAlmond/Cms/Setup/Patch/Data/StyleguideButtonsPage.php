<?php
namespace RedAlmond\Cms\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;

class StyleguideButtonsPage implements DataPatchInterface {
    /**
     * @var \Magento\Cms\Api\Data\PageInterfaceFactory
     */
    private $pageFactory;

    /**
     * @var \Magento\Cms\Api\PageRepositoryInterface
     */
    private $pageRepository;

    public function __construct(
        \Magento\Cms\Api\Data\PageInterfaceFactory $pageFactory,
        \Magento\Cms\Api\PageRepositoryInterface $pageRepository
    ) {
        $this->pageFactory    = $pageFactory;
        $this->pageRepository = $pageRepository;
    }

    /**
     * {@inheritDoc}
     */
    public function apply() {
        try {
            /**
             * @var \Magento\Cms\Api\Data\PageInterface|\Magento\Cms\Model\Page $page
             */
            $page = $this->pageFactory->create();

            $pageData = [
                'identifier'       => 'styleguide-buttons',
                'stores'           => [0],
                'title'            => 'Styleguide Buttons',
                'is_active'        => 1,
                'page_layout'      => '1column',
                'content_heading'  => '',
                'meta_title'       => 'Styleguide Buttons',
                'meta_description' => '',
                'content'          => <<<"EOF"
<style>// styles moved to stylesheet .grid {  display: grid; grid-template-columns: 1fr 1fr 1fr; grid-gap: 40px; }</style>
<h1>BUTTONS</h1>
<div class="grid">
<div class="col"><button class="button primary tocart" type="button"><span><span>Load More</span></span></button></div>
<div class="col"><button class="button btn-continue" title="Continue Shopping" type="button"><span><span>Back To Shop</span></span></button></div>
<div class="col"><button class="action primary checkout" type="button">Checkout</button></div>
</div>
EOF
            ];

            $page->setStoreId($pageData['stores']);

            $page->load($pageData['identifier'], 'identifier');

            $page->addData($pageData);

            $this->pageRepository->save($page);
        } catch (\Exception $e) {
            // do nothing
        }

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
        return [];
    }
}
