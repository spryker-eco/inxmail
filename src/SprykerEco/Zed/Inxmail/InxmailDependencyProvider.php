<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Inxmail;

use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;
use SprykerEco\Zed\Inxmail\Dependency\Facade\InxmailToSalesBridgeFacade;

class InxmailDependencyProvider extends AbstractBundleDependencyProvider
{
    public const FACADE_SALES = 'FACADE_SALES';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container)
    {
        $container = $this->addFacadeSales($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addFacadeSales(Container $container): Container
    {
        $container[static::FACADE_SALES] = function (Container $container) {
            return new InxmailToSalesBridgeFacade($container->getLocator()->sales()->facade());
        };

        return $container;
    }
}
