<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Core\Ecommerce\Product\Application\Delete\ProductDeleter;
use Core\Ecommerce\Product\Domain\ProductNotFound;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class ProductDeleteController extends Controller
{
    public function __construct(private ProductDeleter $deleter) {}

    public function __invoke(Request $request, int $id)
    {
        try {

            $this->deleter->__invoke($id);

            return new JsonResponse([
                'status' => 'success',
                'message' => "Producto eliminado con éxito",
                'data' => []
            ]);
            return;
        } catch (ProductNotFound $ex) {
            return new JsonResponse(['status' => 'ERROR', 'message' => $ex->getMessage()], $this->exceptions()[get_class($ex)]);
        } catch (Exception $ex) {
            Log::channel('Product')->error("[ERROR_PRODUCT] Message: ".$ex->getMessage().PHP_EOL."Trace: ".$ex->getTraceAsString());
            return new JsonResponse(['status' => 'error','message' => $ex->getMessage(), 'trace' => $ex->getTraceAsString()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
    protected function exceptions(): array
    {
        return [
            ProductNotFound::class => Response::HTTP_NOT_FOUND,
        ];
    }
}
