<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package Amasty_Acart
 */


namespace Amasty\Acart\Model\Mail\MessageBuilder;

use Magento\Framework\Mail\EmailMessageInterface;
use Magento\Framework\Mail\EmailMessageInterfaceFactory;
use Magento\Framework\Mail\MessageInterface;
use Magento\Framework\Mail\MimeMessageInterfaceFactory;
use Magento\Framework\ObjectManagerInterface;
use Zend\Mail\Message as ZendMail;

class MessageBuilder
{
    /**
     * @var EmailMessageInterfaceFactory|null
     */
    protected $emailMessageInterfaceFactory = null;

    /**
     * @var MimeMessageInterfaceFactory|null
     */
    protected $mimeMessageInterfaceFactory = null;

    /**
     * @var EmailMessageInterface|MessageInterface
     */
    private $oldMessage;

    /**
     * @var array
     */
    private $parts;

    public function __construct(
        ObjectManagerInterface $objectManager
    ) {
        if (interface_exists(EmailMessageInterface::class)) {
            $this->emailMessageInterfaceFactory = $objectManager->get(EmailMessageInterfaceFactory::class);
            $this->mimeMessageInterfaceFactory = $objectManager->get(MimeMessageInterfaceFactory::class);
        }
    }

    /**
     * @param EmailMessageInterface|MessageInterface $message
     *
     * @return $this
     */
    public function setOldMessage($message)
    {
        $this->parts = $message->getBody()->getParts();
        $this->oldMessage = ZendMail::fromString($message->getRawMessage());

        return $this;
    }

    /**
     * Build email message
     *
     * @return EmailMessageInterface
     */
    public function build()
    {
        $messageData['body'] = $this->mimeMessageInterfaceFactory->create(
            ['parts' => $this->parts]
        );
        $messageData['from'][] = $this->oldMessage->getFrom()->current();
        $messageData['to'][] = $this->oldMessage->getTo()->current();
        $messageData['subject'] = $this->oldMessage->getSubject();
        $message = $this->emailMessageInterfaceFactory->create($messageData);

        return $message;
    }
}
