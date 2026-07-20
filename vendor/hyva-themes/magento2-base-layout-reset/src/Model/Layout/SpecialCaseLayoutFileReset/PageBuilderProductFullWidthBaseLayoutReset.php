<?php
/**
 * Hyvä Themes - https://hyva.io
 * Copyright © Hyvä Themes. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Hyva\BaseLayoutReset\Model\Layout\SpecialCaseLayoutFileReset;

use Hyva\BaseLayoutReset\Model\Layout\GenericBaseLayoutFileReset;
use Hyva\BaseLayoutReset\Model\Layout\MutateXml;

class PageBuilderProductFullWidthBaseLayoutReset implements SpecialCaseBaseLayoutResetInterface
{
    /**
     * @var GenericBaseLayoutFileReset
     */
    private $genericBaseLayoutFileReset;

    /**
     * @var MutateXml
     */
    private $mutateXml;

    public function __construct(
        GenericBaseLayoutFileReset $genericBaseLayoutFileReset,
        MutateXml $mutateXml
    ) {
        $this->genericBaseLayoutFileReset = $genericBaseLayoutFileReset;
        $this->mutateXml = $mutateXml;
    }

    public function matches(string $module, string $filename): bool
    {
        return $module === 'Magento_PageBuilder' && $filename === 'product-full-width.xml';
    }

    public function resetLayout(\SimpleXMLElement $layoutXml): void
    {
        $this->genericBaseLayoutFileReset->resetLayout($layoutXml);

        // product.info.details is a *block* in Hyvä (and in Magento core), but PageBuilder's
        // product-full-width page layout references it via <referenceContainer> in order to
        // remove the product.attributes child block. The generic reset strips that child
        // <referenceBlock remove="true"/>, leaving an empty <referenceContainer
        // name="product.info.details"/> behind. During layout merge,
        // Magento\Framework\View\Layout\Reader\Container::mergeContainerAttributes() then writes
        // empty container attributes onto the block's scheduled structure data, so the block
        // loses its class and template and renders nothing - the description and the other
        // detail sections disappear from the product page. Drop the stale reference so the block
        // definition from the Hyvä theme layout stays intact.
        $this->mutateXml->removeXpath($layoutXml, '//referenceContainer[@name="product.info.details"]');
    }
}
