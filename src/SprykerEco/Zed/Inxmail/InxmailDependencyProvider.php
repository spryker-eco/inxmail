<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */
namespace SprykerEco\Zed\Inxmail;

use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;
use SprykerEco\Zed\Inxmail\Dependency\Facade\InxmailToLocaleFacadeBridge;
use SprykerEco\Zed\Inxmail\Dependency\Facade\InxmailToMoneyFacadeBridge;
use SprykerEco\Zed\Inxmail\Dependency\Facade\InxmailToProductFacadeBridge;
use SprykerEco\Zed\Inxmail\Dependency\Facade\InxmailToSalesFacadeBridge;
use SprykerEco\Zed\Inxmail\Dependency\Service\InxmailToUtilDateTimeServiceBridge;
use SprykerEco\Zed\Inxmail\Dependency\Service\InxmailToUtilEncodingServiceBridge;

class InxmailDependencyProvider extends AbstractBundleDependencyProvider
{
    public const FACADE_SALES = 'FACADE_SALES';
    public const FACADE_MONEY = 'FACADE_MONEY';
    public const FACADE_PRODUCT = 'FACADE_PRODUCT';
    public const FACADE_LOCALE = 'FACADE_LOCALE';

    public const UTIL_DATE_TIME_SERVICE = 'UTIL_DATE_TIME_SERVICE';
    public const UTIL_ENCODING_SERVICE = 'UTIL_ENCODING_SERVICE';

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
        $container = $this->addUtilEncodingService($container);

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
        $container[static::UTIL_DATE_TIME_SERVICE] = function (Container $container) {
            return new InxmailToUtilDateTimeServiceBridge($container->getLocator()->utilDateTime()->service());
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addUtilEncodingService(Container $container): Container
    {
        $container[static::UTIL_ENCODING_SERVICE] = function (Container $container) {
            return new InxmailToUtilEncodingServiceBridge($container->getLocator()->utilEncoding()->service());
        };

        return $container;
    }
}
