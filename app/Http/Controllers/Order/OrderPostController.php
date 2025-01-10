<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Core\Ecommerce\DiscountCode\Domain\DiscountCodeNotFound;
use Core\Ecommerce\Order\Application\Find\OrderCalculator;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class OrderPostController extends Controller
{
    public function __construct(private OrderCalculator $calculator) {}

    public function __invoke(Request $request)
    {
        try {
            $selectedProducts     = $request->selectedProducts;
            $discountCode         = $request->discountCode;

            $calculatorResult = $this->calculator->__invoke($selectedProducts, $discountCode);


            return new JsonResponse([
                'status' => 'success',
                'message' => "Producto creado con éxito",
                'data' => [
                    'subtotal'   => $calculatorResult->subtotal(),
                    'totalDiscountApplied'   => $calculatorResult->totalDiscountApplied(),
                    'totalAdditionalDiscountApplied'   => $calculatorResult->additionalDiscountApplied(),
                    'total'   => $calculatorResult->total(),
                ]], Response::HTTP_CREATED);
        } catch (DiscountCodeNotFound $ex) {
            Log::channel('DiscountCode')->error("[ERROR_DISCOUNT_CODE] Message: ".$ex->getMessage().PHP_EOL."Trace: ".$ex->getTraceAsString());
            return new JsonResponse(['status' => 'error', 'message' => $ex->getMessage()], $this->exceptions()[get_class($ex)]);
        } catch (Exception $ex) {
            Log::channel('Product')->error("[ERROR_CALCULATOR] Message: ".$ex->getMessage().PHP_EOL."Trace: ".$ex->getTraceAsString());
            return new JsonResponse(['status' => 'error','message' => $ex->getMessage(), 'trace' => $ex->getTraceAsString()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    protected function exceptions(): array
    {
        return [
            DiscountCodeNotFound::class => Response::HTTP_NOT_FOUND,
        ];
    }
}
