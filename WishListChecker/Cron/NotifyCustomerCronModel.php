<?php

namespace Astound\WishListChecker\Cron;

use Magento\Framework\App\ObjectManager;
use Astound\WishListChecker\Model\ProxyQuoteFactory;
use Magento\Framework\Mail\TransportInterfaceFactory;

class NotifyCustomerCronModel
{
    protected $mailTransportFactory;

    public function __construct(
        TransportInterfaceFactory $mailTransportFactory
    )
    {
        $this->mailTransportFactory = $mailTransportFactory;
    }

    public function execute()
    {
        $message = new \Magento\Framework\Mail\Message();
        $message->setFrom('mail.recipient@example.com');
        $message->addTo('mail.tosent@example.com');
        $message->setSubject('Subject');
        $message->setBody('Body');
        $transport = $this->mailTransportFactory->create(['message' => $message]);
        $transport->sendMessage();
    }
}