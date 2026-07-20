<?php
namespace MageWorx\OptionFeatures\Ui\DataProvider\Product\Form\ImagesDataProvider;

/**
 * Interceptor class for @see \MageWorx\OptionFeatures\Ui\DataProvider\Product\Form\ImagesDataProvider
 */
class Interceptor extends \MageWorx\OptionFeatures\Ui\DataProvider\Product\Form\ImagesDataProvider implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct($name, $primaryFieldName, $requestFieldName, \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory, \Magento\Framework\App\RequestInterface $request, \Magento\Catalog\Model\Product\Option\Repository $productOptionRepository, \Magento\Catalog\Model\Product\Option\Value $productOptionValueModel, array $addFieldStrategies = [], array $addFilterStrategies = [], array $meta = [], array $data = [])
    {
        $this->___init();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $collectionFactory, $request, $productOptionRepository, $productOptionValueModel, $addFieldStrategies, $addFilterStrategies, $meta, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getData');
        return $pluginInfo ? $this->___callPlugins('getData', func_get_args(), $pluginInfo) : parent::getData();
    }
}
