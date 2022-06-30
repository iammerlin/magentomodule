<?php

namespace Astound\WishListChecker\Cron;

use Magento\Framework\App\ObjectManager;
use Astound\WishListChecker\Model\ProxyQuoteFactory;
use Magento\Framework\Mail\TransportInterfaceFactory;
use Magento\Framework\App\ResourceConnection;
use Magento\Customer\Api\CustomerRepositoryInterface;

class NotifyCustomerCronModel
{
    protected $mailTransportFactory;
    protected $_productRepository;
    protected $_resourceConnection;
    protected $customerRepository;

    public function __construct(
        TransportInterfaceFactory $mailTransportFactory,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Magento\Framework\App\ResourceConnection $_resourceConnection,
        CustomerRepositoryInterface $customerRepository
    )
    {
        $this->mailTransportFactory = $mailTransportFactory;
        $this->_productRepository = $productRepository;
        $this->_resourceConnection = $_resourceConnection;
        $this->customerRepository = $customerRepository;
    }

    public function execute()
    {
        $connection = $this->_resourceConnection->getConnection();
        $wishlist_ordered_product_table = $connection->getTableName('wishlist_ordered_product_table');

        $query1 = "SELECT `customer_id` FROM `" . $wishlist_ordered_product_table . "`";
        $customerIds = $connection->fetchAll($query1);

        $query2 = "SELECT `product_id` FROM `" . $wishlist_ordered_product_table . "`";
        $productIds = $connection->fetchAll($query2);

        for ($i = 0; $i <= count($customerIds); $i++) {
            $product = $this->_productRepository->getById($productIds[$i]);
            $product_name = $product->getName();

            $customer = $this->customerRepository->getById($customerIds[$i]);
            $customer_email = $customer->getEmail();
    
            $message = new \Magento\Framework\Mail\Message();
            $message->setFrom('astound@uzhnu.com');
            $message->addTo($customer_email);
            $message->setSubject('Зменшується кількість товару в вашому wishlist');
            $message->setBody('Зменшується кількість' . $product_name);
            $transport = $this->mailTransportFactory->create(['message' => $message]);
            $transport->sendMessage();
        }

    }
}

