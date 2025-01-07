<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use Core\Ecommerce\Category\Application\Find\CategoryFinder;
use Core\Ecommerce\Category\Domain\CategoryNotFound;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class CategoryGetController extends Controller
{
    /**
     * Handle the incoming request.
     */
    private $finder;

    public function __construct(CategoryFinder $finder)
    {
        $this->finder = $finder;
    }

    public function __invoke($id)
    {
        try {
            $category =  $this->finder->__invoke($id);

            return new JsonResponse([
                'status' => 'success',
                'data' => [
                    'id'       => $category->getId(),
                    'name'     => $category->getName(),
                    'description' => $category->getDescription()
                ]
            ]);
        } catch (CategoryNotFound $ex) {
            Log::channel('TaskType')->error("[ERROR_CATEGORY] Message: ".$ex->getMessage().PHP_EOL."Trace: ".$ex->getTraceAsString());
            return new JsonResponse(['status' => 'error', 'message' => $ex->getMessage()], $this->exceptions()[get_class($ex)]);
        } catch (Exception $ex) {
            Log::channel('TaskType')->error("[ERROR_CATEGORY] Message: ".$ex->getMessage().PHP_EOL."Trace: ".$ex->getTraceAsString());
            return new JsonResponse(['status' => 'error', 'message' => $ex->getMessage(), 'trace' => $ex->getTraceAsString()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    protected function exceptions(): array
    {
        return [
            CategoryNotFound::class => Response::HTTP_NOT_FOUND,
        ];
    }
}
