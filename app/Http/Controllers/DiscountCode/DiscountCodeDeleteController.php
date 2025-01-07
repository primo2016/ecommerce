<?php

namespace App\Http\Controllers\DiscountCode;

use App\Http\Controllers\Controller;
use Core\Ecommerce\DiscountCode\Application\Delete\DiscountCodeDeleter;
use Core\Ecommerce\DiscountCode\Domain\DiscountCodeNotFound;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class DiscountCodeDeleteController extends Controller
{
    public function __construct(private DiscountCodeDeleter $deleter)
    {
    }

    public function __invoke(Request $request, int $id)
    {
        try {

            $this->deleter->__invoke($id);

            return new JsonResponse([
                'status' => 'success',
                'message' => "Código de descuento eliminado con éxito",
                'data' => []]);

            return;
        } catch (DiscountCodeNotFound $ex) {
            return new JsonResponse(['status' => 'ERROR', 'message' => $ex->getMessage()], $this->exceptions()[get_class($ex)]);
        } catch (Exception $ex) {
            Log::channel('DiscountCode')->error("[ERROR_DISCOUNT_CODE] Message: ".$ex->getMessage().PHP_EOL."Trace: ".$ex->getTraceAsString());
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
