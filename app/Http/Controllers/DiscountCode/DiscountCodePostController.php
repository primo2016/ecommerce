<?php

namespace App\Http\Controllers\DiscountCode;

use App\Http\Controllers\Controller;
use App\Http\Requests\DiscountCodeCreateRequest;
use Core\Ecommerce\Category\Application\Find\CategoryFinder;
use Core\Ecommerce\DiscountCode\Application\Create\DiscountCodeCreator;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class DiscountCodePostController extends Controller
{
    public function __construct(private DiscountCodeCreator $creator, private CategoryFinder $categoryFinder)
    {
    }

    public function __invoke(DiscountCodeCreateRequest $createRequest)
    {
        try {
            $request = $createRequest->validated();

            $name           = $request['name'];
            $percent        = $request['percent'];
            $category_id    = $request['category_id'];

            $category = $this->categoryFinder->__invoke($category_id);

            $this->creator->__invoke($name, $category_id, $percent);

            return new JsonResponse([
                'status' => 'success',
                'message' => "Código de descuento creado con éxito",
                'data' => [
                    'name'          => $name,
                    'percent'       => $percent,
                    'category'   => $category->toPrimitives(),
                ]], Response::HTTP_CREATED);

            return;
        } catch (Exception $ex) {
            Log::channel('DiscountCode')->error("[ERROR_DISCOUNT_CODE] Message: ".$ex->getMessage().PHP_EOL."Trace: ".$ex->getTraceAsString());
            return new JsonResponse(['status' => 'error','message' => $ex->getMessage(), 'trace' => $ex->getTraceAsString()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
