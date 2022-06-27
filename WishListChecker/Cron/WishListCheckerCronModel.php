<?php

namespace Astound\WishListChecker\Cron;

use Magento\Framework\App\ObjectManager;

class WishListCheckerCronModel
{
    protected $_salesOrderCollection;

    private $_logger;

    public function __construct(
        \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $salesOrderCollection,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->_salesOrderCollection = $salesOrderCollection;
        $this->_logger = $logger;
    }

    public function execute() {
        $result = [];

        $collection = $this->_salesOrderCollection->create();

        foreach ($collection as $order) {
            foreach ($order->getAllVisibleItems() as $item) {
                $result[] = $item->getSku();
            }
        }
        // $this->_logger->info(var_dump($result));
        return $result;
    }
}