<?php

namespace Astound\WishListChecker\Model;

use Magento\Framework\Model\AbstractModel;

class ProxyQuote extends AbstractModel                                                                                                                                                              
{
    /**
     * cache tag
     */
    const CACHE_TAG = 'wishlist_ordered_product_table';

    /**
     * @var string
     */
    protected $_cacheTag = 'wishlist_ordered_product_table';

    /**
     * @var string
     */
    protected $_eventPrefix = 'wishlist_ordered_product_table';

    protected function _construct()
    {
        $this->_init(
            'Astound\WishListChecker\Model\ResourceModel\ProxyQuote'
        );
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->getData('id');
    }

    /**
     * @return mixed
     */
    public function getCustomerId()
    {
        return $this->getData('customer_id');
    }

    /**
     * @param int $customerId
     * @return Quote
     */
    public function setCustomerId($customerId)
    {
        return $this->setData('customer_id', $customerId);
    }

    /**
     * @return mixed
     */
    public function getProductId()
    {
        return $this->getData('products_id');
    }

    /**
     * @param int $productId
     * @return Quote
     */
    public function setProductId($productId)
    {
        return $this->setData('products_id', $productId);
    }
}