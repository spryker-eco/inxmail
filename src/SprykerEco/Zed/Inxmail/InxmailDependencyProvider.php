<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Inxmail;

use Spryker\Service\UtilDateTime\UtilDateTimeService;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;
use SprykerEco\Zed\Inxmail\Dependency\Facade\InxmailToLocaleFacadeBridge;
use SprykerEco\Zed\Inxmail\Dependency\Facade\InxmailToMoneyFacadeBridge;
use SprykerEco\Zed\Inxmail\Dependency\Facade\InxmailToProductFacadeBridge;
use SprykerEco\Zed\Inxmail\Dependency\Facade\InxmailToSalesFacadeBridge;

class InxmailDependencyProvider extends AbstractBundleDependencyProvider
{
    public const FACADE_SALES = 'FACADE_SALES';
    public const FACADE_MONEY = 'FACADE_MONEY';
    public const FACADE_PRODUCT = 'FACADE_PRODUCT';
    public const FACADE_LOCALE = 'FACADE_LOCALE';

    public const UTIL_DATE_TIME_SERVICE = 'UTIL_DATE_TIME_SERVICE';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container)
    {
        $container = $this->addFacadeSales($container);
        $container = $this->addFacadeMoney($container);
        $container = $this->addFacadeProduct($container);
        $container = $this->addFacadeLocale($container);
        $container = $this->addUtilDateTimeService($container);

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

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addFacadeProduct(Container $container): Container
    {
        $container[static::FACADE_PRODUCT] = function (Container $container) {
            return new InxmailToProductFacadeBridge($container->getLocator()->product()->facade());
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addFacadeLocale(Container $container): Container
    {
        $container[static::FACADE_LOCALE] = function (Container $container) {
            return new InxmailToLocaleFacadeBridge($container->getLocator()->locale()->facade());
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addUtilDateTimeService(Container $container): Container
    {
        $container[static::UTIL_DATE_TIME_SERVICE] = function () {
            return new UtilDateTimeService();
        };

        return $container;
    }
}
