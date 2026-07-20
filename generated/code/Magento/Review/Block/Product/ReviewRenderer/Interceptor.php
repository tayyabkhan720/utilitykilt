<?php
namespace Magento\Review\Block\Product\ReviewRenderer;

/**
 * Interceptor class for @see \Magento\Review\Block\Product\ReviewRenderer
 */
class Interceptor extends \Magento\Review\Block\Product\ReviewRenderer implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Element\Template\Context $context, \Magento\Review\Model\ReviewFactory $reviewFactory, array $data = [], ?\Magento\Review\Model\ReviewSummaryFactory $reviewSummaryFactory = null, ?\Magento\Review\Model\AppendSummaryDataFactory $appendSummaryDataFactory = null)
    {
        $this->___init();
        parent::__construct($context, $reviewFactory, $data, $reviewSummaryFactory, $appendSummaryDataFactory);
    }

    /**
     * {@inheritdoc}
     */
    public function toHtml()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'toHtml');
        return $pluginInfo ? $this->___callPlugins('toHtml', func_get_args(), $pluginInfo) : parent::toHtml();
    }
}
