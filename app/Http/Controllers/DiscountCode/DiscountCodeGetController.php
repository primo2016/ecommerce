<?php

namespace App\Http\Controllers\DiscountCode;

use App\Http\Controllers\Controller;
use Core\Ecommerce\DiscountCode\Application\Find\DiscountCodeFinder;
use Core\Ecommerce\DiscountCode\Domain\DiscountCodeNotFound;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class DiscountCodeGetController extends Controller
{
    /**
     * Handle the incoming request.
     */
    private $finder;

    public function __construct(DiscountCodeFinder $finder)
    {
        $this->finder = $finder;
    }

    public function __invoke($id)
    {
        try {
            $discountCode =  $this->finder->__invoke($id);

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
