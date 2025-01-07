<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use Core\Ecommerce\Category\Application\Delete\CategoryDeleter;
use Core\Ecommerce\Category\Domain\CategoryNotFound;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class CategoryDeleteController extends Controller
{
    public function __construct(private CategoryDeleter $deleter)
    {
    }

    public function __invoke(Request $request, int $id)
    {
        try {

            $this->deleter->__invoke($id);

            return new JsonResponse([
                'status' => 'success',
                'message' => "Categoría eliminada con éxito",
                'data' => []]);

            return;
        } catch (CategoryNotFound $ex) {
            return new JsonResponse(['status' => 'ERROR', 'message' => $ex->getMessage()], $this->exceptions()[get_class($ex)]);
        } catch (Exception $ex) {
            Log::channel('Category')->error("[ERROR_CATEGORY] Message: ".$ex->getMessage().PHP_EOL."Trace: ".$ex->getTraceAsString());
            return new JsonResponse(['status' => 'error','message' => $ex->getMessage(), 'trace' => $ex->getTraceAsString()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
    protected function exceptions(): array
    {
        return [
            CategoryNotFound::class => Response::HTTP_NOT_FOUND,
        ];
    }
}
