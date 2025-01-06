<?php
/**
 * Copyright © Reach Digital (https://www.reachdigital.io/)
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace GraphCommerce\Metapack\Block\Adminhtml\System\Config\Form\Field;

use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Config\Block\System\Config\Form\Field;

class ReadOnlyText extends Field
{
    protected function _getElementHtml(AbstractElement $element): string
    {
        $element->setReadonly(true);
        return $element->getElementHtml();
    }
}
