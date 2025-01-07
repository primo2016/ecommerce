<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use Core\Ecommerce\Category\Application\Create\CategoryCreator;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class CategoryPostController extends Controller
{
    public function __construct(private CategoryCreator $creator)
    {
        $this->creator = $creator;
    }

    public function __invoke(Request $request)
    {
        try {
            $name           = $request->name;
            $description    = $request->description;
            $this->creator->__invoke($name, $description);

            return new JsonResponse([
                'status' => 'success',
                'message' => "Categoría creada con éxito",
                'data' => [
                    'name'          => $name,
                    'description'   => $description,
                ]], Response::HTTP_CREATED);

            return;
        } catch (Exception $ex) {
            Log::channel('Category')->error("[ERROR_CATEGORY] Message: ".$ex->getMessage().PHP_EOL."Trace: ".$ex->getTraceAsString());
            return new JsonResponse(['status' => 'error','message' => $ex->getMessage(), 'trace' => $ex->getTraceAsString()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}
