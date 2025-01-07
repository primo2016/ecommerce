<?php

namespace App\Http\Controllers\DiscountCode;

use Core\Ecommerce\DiscountCode\Application\DiscountCodeResponse;
use Core\Ecommerce\DiscountCode\Application\Find\DiscountCodeSearcherAll;
use Core\Ecommerce\DiscountCode\Domain\DiscountCodesNotFound;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Exception;

use function Lambdish\Phunctional\map;

class DiscountCodeGetAllController extends Controller
{
    public function __construct(private DiscountCodeSearcherAll $searcher)
    {
        $this->searcher = $searcher;
    }
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        try {
            $response =  $this->searcher->__invoke();

            return new JsonResponse([
                'status' => 'success',
                'data' => map(
                    fn(DiscountCodeResponse $response) => [
                        'id'       => $response->id(),
                        'name'     => $response->name(),
                        'percent'  => $response->percent(),
                        'category_id'  => $response->category_id(),
                    ],
                    $response->discountCodes()
                ),]);
            return;
        } catch (DiscountCodesNotFound $ex) {
            Log::channel('DiscountCode')->error("[ERROR_DISCOUNTCODE] Message: ".$ex->getMessage().PHP_EOL."Trace: ".$ex->getTraceAsString());
            return new JsonResponse(['status' => 'error', 'message' => $ex->getMessage()], $this->exceptions()[get_class($ex)]);
        } catch (Exception $ex) {
            Log::channel('DiscountCode')->error("[ERROR_DISCOUNTCODE] Message: ".$ex->getMessage().PHP_EOL."Trace: ".$ex->getTraceAsString());
            return new JsonResponse(['status' => 'error', 'message' => $ex->getMessage(), 'trace' => $ex->getTraceAsString()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    protected function exceptions(): array
    {
        return [
            DiscountCodesNotFound::class => Response::HTTP_NOT_FOUND,
        ];
    }
}
