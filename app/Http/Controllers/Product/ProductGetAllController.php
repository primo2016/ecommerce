<?php

namespace App\Http\Controllers\Product;

use Core\Ecommerce\Product\Application\ProductResponse;
use Core\Ecommerce\Product\Application\Find\ProductSearcherAll;
use Core\Ecommerce\Product\Domain\ProductsNotFound;
use App\Http\Controllers\Controller;
use Core\Ecommerce\Category\Application\CategoryResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Exception;

use function Lambdish\Phunctional\map;

class ProductGetAllController extends Controller
{
    public function __construct(private ProductSearcherAll $searcher)
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
                    fn(ProductResponse $response) => [
                        'id'       => $response->id(),
                        'name'     => $response->name(),
                        'amount'     => $response->amount(),
                        'description' => $response->description(),
                        'categories'    => $response->categories()
                    ],
                    $response->products()
                ),]);
            return;
        } catch (ProductsNotFound $ex) {
            Log::channel('Product')->error("[ERROR_PRODUCT] Message: ".$ex->getMessage().PHP_EOL."Trace: ".$ex->getTraceAsString());
            return new JsonResponse(['status' => 'error', 'message' => $ex->getMessage()], $this->exceptions()[get_class($ex)]);
        } catch (Exception $ex) {
            Log::channel('Product')->error("[ERROR_PRODUCT] Message: ".$ex->getMessage().PHP_EOL."Trace: ".$ex->getTraceAsString());
            return new JsonResponse(['status' => 'error', 'message' => $ex->getMessage(), 'trace' => $ex->getTraceAsString()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    protected function exceptions(): array
    {
        return [
            ProductsNotFound::class => Response::HTTP_NOT_FOUND,
        ];
    }
}
