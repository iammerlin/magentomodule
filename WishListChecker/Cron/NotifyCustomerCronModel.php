<?php

namespace Astound\WishListChecker\Cron;

use Magento\Framework\App\ObjectManager;
use Astound\WishListChecker\Model\ProxyQuoteFactory;
use Magento\Framework\Mail\Template\TransportBuilder;

class NotifyCustomerCronModel
{
	protected $_productRepository;
    private $_logger;
    private $transportBuilder;

    public function __construct(
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder
    ) {
        $this->_productRepository = $productRepository;
        $this->_logger = $logger;
        $this->transportBuilder = $transportBuilder;
    }

    public function execute() {
        $result = [];

        // $product = $this->_productRepository->getById("1562");
        // var_dump($product->getName());

        try {
            $templateVars = [];
            $transport = $this->transportBuilder->setTemplateIdentifier('59')
            ->setTemplateOptions( [ 'area' => \Magento\Framework\App\Area::AREA_FRONTEND, 'store' => 1 ] )
            ->setTemplateVars( $templateVars )
            ->setFrom( [ "name" => "Magento ABC CHECK PAYMENT", "email" => "memcached7@gmail.com" ] )
            ->addTo('memcached7@gmail.com')
            ->setReplyTo('memcached7@gmail.com')
            ->getTransport();
            $transport->sendMessage(); 
        } catch (Exception $e) {
            $this->logger->error($e);
        }

        return $result;
    }
}