<?php
namespace Utility\CheckoutComments\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Quote\Model\Quote;

class CustomerNote implements ResolverInterface
{
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        /** @var Quote $quote */
        $quote = $value['model'] ?? null;
        return $quote ? $quote->getCustomerNote() : '';
    }
}