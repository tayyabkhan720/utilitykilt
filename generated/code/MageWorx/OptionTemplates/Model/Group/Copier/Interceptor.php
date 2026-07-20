<?php
namespace MageWorx\OptionTemplates\Model\Group\Copier;

/**
 * Interceptor class for @see \MageWorx\OptionTemplates\Model\Group\Copier
 */
class Interceptor extends \MageWorx\OptionTemplates\Model\Group\Copier implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\MageWorx\OptionTemplates\Model\GroupFactory $groupFactory, \MageWorx\OptionTemplates\Model\ResourceModel\Group $resourceModel, \MageWorx\OptionTemplates\Model\ResourceModel\Group\Option $optionResourceModel)
    {
        $this->___init();
        parent::__construct($groupFactory, $resourceModel, $optionResourceModel);
    }

    /**
     * {@inheritdoc}
     */
    public function copy(\MageWorx\OptionTemplates\Model\Group $group)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'copy');
        return $pluginInfo ? $this->___callPlugins('copy', func_get_args(), $pluginInfo) : parent::copy($group);
    }
}
