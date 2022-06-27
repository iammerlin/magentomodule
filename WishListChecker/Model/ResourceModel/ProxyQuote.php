<?php

class ProxyQuote extends AbstractDb                                                                                                                                                                 
{
    protected $_idFieldName = 'id';

    protected function _construct()
    {
        $this->_init('proxy_quote', $this->_idFieldName);
    }
}