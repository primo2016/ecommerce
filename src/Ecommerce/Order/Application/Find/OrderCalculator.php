<?php

namespace Core\Ecommerce\Order\Application\Find;

use Core\Ecommerce\DiscountCode\Application\Find\DiscountCodeFilter;
use Core\Ecommerce\Order\Application\OrderResponse;
use Core\Ecommerce\Product\Application\Find\ProductFilterByIds;
use Core\Ecommerce\Product\Domain\ProductRepository;

final class OrderCalculator
{
    private $productFilter;
    public function __construct(private ProductRepository $repository, private DiscountCodeFilter $discountCodeFilter)
    {
        $this->productFilter = new ProductFilterByIds($repository);
    }

    public function __invoke(array $selectedProducts, ?string $discountCode)
    {
        $subtotal = 0;
        $total = 0;
        $discountAppled = 0;
        $newDiscountToApply = 0;
        $additionalDiscountAppled = 0;
        
        $resultArray = $this->productFilter->__invoke($selectedProducts);

        foreach ($resultArray->products() as $product) {
            $subtotal += $product->amount();
            $discountAppled += $product->discountToApply()
                ? ($product->amount() * $product->discountToApply() / 100)
                : 0;
            $total += $product->discountToApply()
            ? ($product->amount() - $product->amount() * $product->discountToApply() / 100)
            : $product->amount();
        }

        if($discountCode) {
            $newDiscountToApply = $this->discountCodeFilter->__invoke($discountCode);

            if($newDiscountToApply) {
                $additionalDiscountAppled = ($total * $newDiscountToApply->getPercent() / 100);

                $total -= $additionalDiscountAppled;
            }
        }

        return new OrderResponse(
            $subtotal,
            $discountAppled,
            $additionalDiscountAppled,
            $total
        );
    }

}
