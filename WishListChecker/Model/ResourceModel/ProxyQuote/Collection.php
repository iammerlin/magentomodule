class Collection extends AbstractCollection                                                                                                                                                         
{
    protected $_idFieldName = 'entity_id';

    protected function _construct()
    {
        $this->_init(
            'My\Module\Model\ProxyQuote',
            'My\Module\Model\ResourceModel\ProxyQuote'
        );
    }
}