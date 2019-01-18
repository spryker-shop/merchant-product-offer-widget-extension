<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\AvailabilityNotificationPage\Plugin\Provider;

use Silex\Application;
use SprykerShop\Yves\ShopApplication\Plugin\Provider\AbstractYvesControllerProvider;

class AvailabilityNotificationPageControllerProvider extends AbstractYvesControllerProvider
{
    public const ROUTE_AVAILABILITY_NOTIFICATION_UNSUBSCRIBE = 'availability-notification/unsubscribe-by-key';

    public const PARAM_SUBSCRIPTION_KEY = 'subscriptionKey';

    /**
     * @param \Silex\Application $app
     *
     * @return void
     */
    protected function defineControllers(Application $app)
    {
        $this->addAvailabilityNotificationUnsubscribeRoute();
    }

    /**
     * @return $this
     */
    protected function addAvailabilityNotificationUnsubscribeRoute(): self
    {
        $this->createGetController('/{notificationAvailability}/unsubscribe-by-key', static::ROUTE_AVAILABILITY_NOTIFICATION_UNSUBSCRIBE, 'AvailabilityNotificationPage', 'AvailabilityNotificationPage', 'unsubscribe')
            ->assert('notificationAvailability', $this->getAllowedLocalesPattern() . 'availability-notification|availability-notification')
            ->assert(static::PARAM_SUBSCRIPTION_KEY, '\[0-9A-Za-z]{32}')
            ->value('notificationAvailability', 'availability-notification');

        return $this;
    }
}
