<?php
namespace Utility\CheckoutComments\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Quote\Model\QuoteIdMaskFactory;
use Magento\Quote\Api\CartRepositoryInterface;

class SetCustomerNoteOnCart implements ResolverInterface
{
    private $quoteIdMaskFactory;
    private $cartRepository;

    public function __construct(
        QuoteIdMaskFactory $quoteIdMaskFactory,
        CartRepositoryInterface $cartRepository
    ) {
        $this->quoteIdMaskFactory = $quoteIdMaskFactory;
        $this->cartRepository = $cartRepository;
    }

    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        $maskedCartId = $args['input']['cart_id'] ?? '';
        $note = $args['input']['note'] ?? '';

        $quoteIdMask = $this->quoteIdMaskFactory->create()->load($maskedCartId, 'masked_id');
        if (!$quoteIdMask->getId()) {
            throw new NoSuchEntityException(__('Could not find a cart with ID "%1"', $maskedCartId));
        }

        $quote = $this->cartRepository->get($quoteIdMask->getQuoteId());
        $quote->setCustomerNote($note);
        $this->cartRepository->save($quote);

        return [
            'cart' => [
                'model' => $quote,
            ],
        ];
    }
}