<?php

namespace Astound\WishListChecker\Model\ResourceModel\ProxyQuote;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection                                                                                                                                                         
{
    protected $_idFieldName = 'id';

    protected function _construct()
    {
        $this->_init(
            'Astound\WishListChecker\Model\ProxyQuote',
            'Astound\WishListChecker\Model\ResourceModel\ProxyQuote'
        );
    }
}