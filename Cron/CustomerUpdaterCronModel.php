<?php

namespace Astound\WishListChecker\Cron;

use Magento\Framework\App\ObjectManager;
use Astound\WishListChecker\Model\ProxyQuoteFactory;

class WishListCheckerCronModel
{
    protected $_salesOrderCollection;
    protected $_proxyQuoteFactory;
    private $_logger;

    public function __construct(
        \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $salesOrderCollection,
        \Psr\Log\LoggerInterface $logger,
        \Astound\WishListChecker\Model\ProxyQuoteFactory $_proxyQuoteFactory
    ) {
        $this->_salesOrderCollection = $salesOrderCollection;
        $this->_logger = $logger;
        $this->_proxyQuoteFactory = $_proxyQuoteFactory;
    }

    public function execute() {
        $result = [];

        $collection = $this->_salesOrderCollection->create();

        foreach ($collection as $order) {
            foreach ($order->getAllVisibleItems() as $item) {
                $proxyQuote = $this->_proxyQuoteFactory->create();
                $proxyQuote->setProductId(intval($item->getProductId()));
                $proxyQuote->save();
            }
        }

        $this->_logger->info(var_dump($result));
        return $result;
    }
}