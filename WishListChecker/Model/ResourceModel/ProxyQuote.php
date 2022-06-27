<?php

namespace Astound\WishListChecker\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class ProxyQuote extends AbstractDb                                                                                                                                                                 
{
    protected $_idFieldName = 'id';

    protected function _construct()
    {
        $this->_init('wishlist_ordered_product_table', $this->_idFieldName);
    }
}