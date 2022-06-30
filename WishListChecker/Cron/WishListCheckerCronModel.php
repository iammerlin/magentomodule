<?php

namespace Astound\WishListChecker\Cron;

use Magento\Framework\App\ObjectManager;
use Astound\WishListChecker\Model\ProxyQuoteFactory;
use Magento\Wishlist\Model\ResourceModel\Item\CollectionFactory;
use Magento\Framework\App\ResourceConnection;

class WishListCheckerCronModel
{
    protected $_salesOrderCollection;
    protected $_proxyQuoteFactory;
    protected $_wishListItemFactory;
    protected $_resourceConnection;
    private $_logger;

    public function __construct(
        \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $salesOrderCollection,
        \Psr\Log\LoggerInterface $logger,
        \Astound\WishListChecker\Model\ProxyQuoteFactory $_proxyQuoteFactory,
        \Magento\Wishlist\Model\ResourceModel\Item\CollectionFactory $_wishListItemFactory,
        \Magento\Framework\App\ResourceConnection $_resourceConnection
    ) {
        $this->_salesOrderCollection = $salesOrderCollection;
        $this->_logger = $logger;
        $this->_proxyQuoteFactory = $_proxyQuoteFactory;
        $this->_wishListItemFactory = $_wishListItemFactory;
        $this->_resourceConnection = $_resourceConnection;
    }

    public function execute() {
        $productIds = [];

        $collection = $this->_salesOrderCollection->create();
        $connection = $this->_resourceConnection->getConnection();
        $table_wishlist_item = $connection->getTableName('wishlist_item');
        $table_wishlist = $connection->getTableName('wishlist');

        foreach ($collection as $order) {
            foreach ($order->getAllVisibleItems() as $item) {
                if (!in_array($item->getProductId(), $productIds)) {
                    $query1 = "SELECT `wishlist_id` FROM `" . $table_wishlist_item . "` WHERE product_id = ". $item->getProductId() ." ";
                    $wishListIds = $connection->fetchAll($query1);
                    if ($wishListIds) {
                        foreach ($wishListIds as $wishId) {
                            $query2 = "SELECT `customer_id` FROM `" . $table_wishlist . "` WHERE wishlist_id = ". $wishId["wishlist_id"] ." ";
                            $customerId = $connection->fetchAll($query2)[0]["customer_id"];
                            $proxyQuote = $this->_proxyQuoteFactory->create();
                            $proxyQuote->setProductId(intval($item->getProductId()));
                            $proxyQuote->setCustomerId(intval($customerId));
                            $proxyQuote->save();
                        }
                    }
                    $productIds[] = $item->getProductId();
                }
            }
        }
        return $this;
    }
}