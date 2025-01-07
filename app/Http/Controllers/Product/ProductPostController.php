<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Core\Ecommerce\Category\Application\CategoryResponse;
use Core\Ecommerce\Category\Application\Find\CategoryFilterById;
use Core\Ecommerce\Product\Application\Create\ProductCreator;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

use function Lambdish\Phunctional\map;

class ProductPostController extends Controller
{
    public function __construct(private ProductCreator $creator, private CategoryFilterById $categoryFilter) {}

    public function __invoke(Request $request)
    {
        try {
            $name           = $request->name;
            $amount         = $request->amount;
            $description    = $request->description;
            $catetory_ids   = $request->catetories;

            $categoryResponse = $this->categoryFilter->__invoke($catetory_ids);

            if(is_array($categoryResponse) && count($categoryResponse)) {

                $this->creator->__invoke($name, $description, $amount, $categoryResponse);

                return new JsonResponse([
                    'status' => 'success',
                    'message' => "Producto creado con éxito",
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
        } catch (Exception $ex) {
            Log::channel('Product')->error("[ERROR_PRODUCT] Message: ".$ex->getMessage().PHP_EOL."Trace: ".$ex->getTraceAsString());
            return new JsonResponse(['status' => 'error','message' => $ex->getMessage(), 'trace' => $ex->getTraceAsString()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}
