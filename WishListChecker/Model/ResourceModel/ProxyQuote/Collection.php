<?php

class Collection extends AbstractCollection                                                                                                                                                         
{
    protected $_idFieldName = 'entity_id';

    protected function _construct()
    {
        $this->_init(
            'Astound\WishListChecker\Model\ProxyQuote',
            'Astound\WishListChecker\Model\ResourceModel\ProxyQuote'
        );
    }
}