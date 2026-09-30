<?php
declare(strict_types=1);

namespace TJV\PromoShipping\Model\Config\Source;

use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;
use Magento\Framework\Data\OptionSourceInterface;

class Categories implements OptionSourceInterface
{
    /** @var CollectionFactory */
    private CollectionFactory $collectionFactory;

    /** @var array|null */
    private ?array $options = null;

    /**
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(CollectionFactory $collectionFactory)
    {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Return all categories (below the root catalog) with their full path as label.
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        if ($this->options !== null) {
            return $this->options;
        }

        $collection = $this->collectionFactory->create();
        $collection->setStoreId(0)->addAttributeToSelect('name');

        $names = [];
        foreach ($collection as $category) {
            $names[(int)$category->getId()] = (string)$category->getName();
        }

        $options = [];
        foreach ($collection as $category) {
            if ((int)$category->getLevel() < 2) {
                continue; // skip the root catalog
            }
            $ids = array_slice(explode('/', (string)$category->getPath()), 1);
            $label = implode(' > ', array_map(
                static fn($id) => $names[(int)$id] ?? (string)$id,
                $ids
            ));
            $options[] = ['value' => (int)$category->getId(), 'label' => $label];
        }

        usort($options, static fn($a, $b) => strcasecmp($a['label'], $b['label']));

        return $this->options = $options;
    }
}