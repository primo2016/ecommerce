<?php

namespace App\Http\Controllers\DiscountCode;

use App\Http\Controllers\Controller;
use Core\Ecommerce\DiscountCode\Application\Find\DiscountCodeFilter;
use Core\Ecommerce\DiscountCode\Domain\DiscountCodeNotFound;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Exception;

class DiscountCodeGetByNameController extends Controller
{
    public function __construct(private DiscountCodeFilter $finder)
    {
    }

    public function __invoke($code)
    {
        try {
            $discountCode =  $this->finder->__invoke($code);

            return new JsonResponse([
                'status' => 'success',
                'data' => [
                    'id'        => $discountCode->getId(),
                    'name'      => $discountCode->getName(),
                    'percent'   => $discountCode->getPercent(),
                    'category_id'   => $discountCode->getCategoryId(),
                ]
            ]);
        } catch (DiscountCodeNotFound $ex) {
            Log::channel('DiscountCode')->error("[ERROR_DISCOUNT_CODE] Message: ".$ex->getMessage().PHP_EOL."Trace: ".$ex->getTraceAsString());
            return new JsonResponse(['status' => 'error', 'message' => $ex->getMessage()], $this->exceptions()[get_class($ex)]);
        } catch (Exception $ex) {
            Log::channel('DiscountCode')->error("[ERROR_DISCOUNT_CODE] Message: ".$ex->getMessage().PHP_EOL."Trace: ".$ex->getTraceAsString());
            return new JsonResponse(['status' => 'error', 'message' => $ex->getMessage(), 'trace' => $ex->getTraceAsString()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    protected function exceptions(): array
    {
        return [
            DiscountCodeNotFound::class => Response::HTTP_NOT_FOUND,
        ];
    }
}
