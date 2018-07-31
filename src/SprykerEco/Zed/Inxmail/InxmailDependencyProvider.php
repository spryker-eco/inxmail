<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Inxmail;

use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;
use SprykerEco\Zed\Inxmail\Dependency\Facade\InxmailToMoneyFacadeBridge;
use SprykerEco\Zed\Inxmail\Dependency\Facade\InxmailToSalesFacadeBridge;

class InxmailDependencyProvider extends AbstractBundleDependencyProvider
{
    public const FACADE_SALES = 'FACADE_SALES';
    public const FACADE_MONEY = 'FACADE_MONEY';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container)
    {
        $container = $this->addFacadeSales($container);
        $container = $this->addFacadeMoney($container);

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
            return new InxmailToSalesFacadeBridge($container->getLocator()->sales()->facade());
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addFacadeMoney(Container $container): Container
    {
        $container[static::FACADE_MONEY] = function (Container $container) {
            return new InxmailToMoneyFacadeBridge($container->getLocator()->money()->facade());
        };

        return $container;
    }
}
