<?php

namespace App\Http\Controllers\Category;

use Core\Ecommerce\Category\Application\CategoryResponse;
use Core\Ecommerce\Category\Application\Find\CategorySearcherAll;
use Core\Ecommerce\Category\Domain\CategoriesNotFound;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Exception;

use function Lambdish\Phunctional\map;

class CategoryGetAllController extends Controller
{
    public function __construct(private CategorySearcherAll $searcher)
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
                    fn(CategoryResponse $response) => [
                        'id'       => $response->id(),
                        'name'     => $response->name(),
                        'description' => $response->description()
                    ],
                    $response->categories()
                ),]);
            return;
        } catch (CategoriesNotFound $ex) {
            Log::channel('Category')->error("[ERROR_CATEGORY] Message: ".$ex->getMessage().PHP_EOL."Trace: ".$ex->getTraceAsString());
            return new JsonResponse(['status' => 'error', 'message' => $ex->getMessage()], $this->exceptions()[get_class($ex)]);
        } catch (Exception $ex) {
            Log::channel('Category')->error("[ERROR_CATEGORY] Message: ".$ex->getMessage().PHP_EOL."Trace: ".$ex->getTraceAsString());
            return new JsonResponse(['status' => 'error', 'message' => $ex->getMessage(), 'trace' => $ex->getTraceAsString()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    protected function exceptions(): array
    {
        return [
            CategoriesNotFound::class => Response::HTTP_NOT_FOUND,
        ];
    }
}
