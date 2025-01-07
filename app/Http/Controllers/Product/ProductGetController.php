<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Core\Ecommerce\Product\Application\Find\ProductFinder;
use Core\Ecommerce\Product\Domain\ProductNotFound;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class ProductGetController extends Controller
{
    /**
     * Handle the incoming request.
     */
    private $finder;

    public function __construct(ProductFinder $finder)
    {
        $this->finder = $finder;
    }

    public function __invoke($id)
    {
        try {
            $product =  $this->finder->__invoke($id);

            return new JsonResponse([
                'status' => 'success',
                'data' => [
                    'id'       => $product->getId(),
                    'name'     => $product->getName(),
                    'amount'   => $product->getAmount(),
                    'description'   => $product->getDescription(),
                    'categories'    => $product->getCategoryMap()
                ]
            ]);
        } catch (ProductNotFound $ex) {
            Log::channel('TaskType')->error("[ERROR_PRODUCT] Message: ".$ex->getMessage().PHP_EOL."Trace: ".$ex->getTraceAsString());
            return new JsonResponse(['status' => 'error', 'message' => $ex->getMessage()], $this->exceptions()[get_class($ex)]);
        } catch (Exception $ex) {
            Log::channel('TaskType')->error("[ERROR_PRODUCT] Message: ".$ex->getMessage().PHP_EOL."Trace: ".$ex->getTraceAsString());
            return new JsonResponse(['status' => 'error', 'message' => $ex->getMessage(), 'trace' => $ex->getTraceAsString()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    protected function exceptions(): array
    {
        return [
            ProductNotFound::class => Response::HTTP_NOT_FOUND,
        ];
    }
}
