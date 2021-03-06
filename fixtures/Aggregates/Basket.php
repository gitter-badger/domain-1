<?php

namespace Domain\Fixtures\Aggregates;

use Domain\Fixtures\Identity\BasketId;
use Domain\Fixtures\Identity\ProductId;
use Domain\Fixtures\Events\BasketWasPickedUp;
use Domain\Fixtures\Events\ProductWasAdded;
use Domain\Aggregates\BaseAggregateRoot;

/**
 * @author Sebastiaan Hilbers <bashilbers@gmail.com>
 */
final class Basket extends BaseAggregateRoot
{
    private $products = [];

    public static function pickup(BasketId $basketId)
    {
        $basket = new Basket($basketId);

        $basket->recordThat(
            new BasketWasPickedUp($basketId)
        );

        return $basket;
    }

    public function addProduct(ProductId $productId)
    {
        $this->recordThat(
            new ProductWasAdded($this->getIdentity(), $productId)
        );
    }

    public function getProductCount()
    {
        return count($this->products);
    }

    protected function whenBasketWasPickedUp(BasketWasPickedUp $event)
    {
        $this->products = [];
    }

    protected function whenProductWasAdded(ProductWasAdded $event)
    {
        $this->products[] = (string) $event->getProductId();
    }
}
