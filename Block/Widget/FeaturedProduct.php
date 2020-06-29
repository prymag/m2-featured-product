<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Prymag\FeaturedProduct\Block\Widget;
use Magento\Widget\Block\BlockInterface;
use Magento\CatalogUrlRewrite\Model\ProductUrlRewriteGenerator;
use Magento\UrlRewrite\Service\V1\Data\UrlRewrite;

class FeaturedProduct extends \Magento\Framework\View\Element\Html\Link implements BlockInterface {

	protected $_href;
	
	public function _construct()
	{
		$this->setTemplate('Prymag_FeaturedProduct::widget/featured-product-item.phtml');
	}
	
	protected $_productRepository;
		
	public function __construct(
		\Magento\Backend\Block\Template\Context $context,		
		\Magento\Catalog\Model\ProductRepository $productRepository,
		array $data = []
	)
	{
		$this->_productRepository = $productRepository;
		parent::__construct($context, $data);
	}
	
	public function getProductById($id)
	{
		return $this->_productRepository->getById($id);
	}
	
	public function getProductBySku($sku)
	{
		return $this->_productRepository->get($sku);
	}
	
	/**
     * Parse id_path
     *
     * @param string $idPath
     * @throws \RuntimeException
     * @return array
     */
    protected function parseIdPath($idPath)
    {
        $rewriteData = explode('/', $idPath);

        if (!isset($rewriteData[0]) || !isset($rewriteData[1])) {
            throw new \RuntimeException('Wrong id_path structure.');
        }
        return $rewriteData;
    }
	
	public function	getTheProduct() {
		$rewriteData = $this->parseIdPath($this->getData('id_path'));
		return $this->getProductById($rewriteData[1]);
	}
	
	public function getFeaturedImage() {
		$mediaUrl = $this ->_storeManager-> getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA );
		return $mediaUrl . $this->getData('featured_image');
	}
	
	public function getShortDescription() {
		return $this->getData('short_desc');
	}
}