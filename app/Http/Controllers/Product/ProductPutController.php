<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Core\Ecommerce\Category\Application\CategoryResponse;
use Core\Ecommerce\Category\Application\Find\CategoryFilterById;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Core\Ecommerce\Product\Domain\ProductNotFound;
use Core\Ecommerce\Product\Application\Update\ProductUpdater;

use function Lambdish\Phunctional\map;

class ProductPutController extends Controller
{
    public function __construct(private ProductUpdater $updater, private CategoryFilterById $categoryFilter)
    {}

    public function __invoke(Request $request, int $id)
    {
        try {
            $name           = $request->name;
            $amount           = $request->amount;
            $description    = $request->description;
            $catetory_ids   = $request->catetories;

            $categoryResponse = $this->categoryFilter->__invoke($catetory_ids);

            if(is_array($categoryResponse) && count($categoryResponse)) {

                $this->updater->__invoke($id, $name, $description, $amount, $categoryResponse);

                return new JsonResponse([
                    'status' => 'success',
                    'message' => "Producto actualizado con éxito",
                    'data' => [
                        'name'          => $name,
                        'amount'        => $amount,
                        'description'   => $description,
                        'categories'    => map(
                            fn(CategoryResponse $category) => [
                                'id'       => $category->id(),
                                'name'     => $category->name(),
                                'description' => $category->description()
                            ],
                            $categoryResponse)
                    ]], Response::HTTP_CREATED);

            } else {
                return new JsonResponse([
                    'status' => 'error',
                    'message' => "Las categorías son requeridas"], Response::HTTP_NOT_ACCEPTABLE);
            }
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
