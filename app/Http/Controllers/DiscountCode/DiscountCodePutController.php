<?php

namespace App\Http\Controllers\DiscountCode;

use App\Http\Controllers\Controller;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Core\Ecommerce\DiscountCode\Domain\DiscountCodeNotFound;
use Core\Ecommerce\DiscountCode\Application\Update\DiscountCodeUpdater;

class DiscountCodePutController extends Controller
{
    public function __construct(private DiscountCodeUpdater $updater)
    {
        $this->updater = $updater;
    }

    public function __invoke(Request $request, int $id)
    {
        try {
            $name           = $request->name;
            $percent        = $request->percent;
            $category_id    = $request->category_id;
            $this->updater->__invoke($id, $name, $category_id, $percent);

            return new JsonResponse([
                'status' => 'success',
                'message' => "DiscountCodeo actualizado con éxito",
                'data' => [
                    'name'          => $name,
                    'category_id'   => $category_id,
                    'percent'   => $percent,
                ]], Response::HTTP_CREATED);

            return;
        } catch (DiscountCodeNotFound $ex) {
            return new JsonResponse(['status' => 'ERROR', 'message' => $ex->getMessage()], $this->exceptions()[get_class($ex)]);
        } catch (Exception $ex) {
            Log::channel('DiscountCode')->error("[ERROR_DISCOUNT_CODE] Message: ".$ex->getMessage().PHP_EOL."Trace: ".$ex->getTraceAsString());
            return new JsonResponse(['status' => 'error','message' => $ex->getMessage(), 'trace' => $ex->getTraceAsString()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
    protected function exceptions(): array
    {
        return [
            DiscountCodeNotFound::class => Response::HTTP_NOT_FOUND,
        ];
    }
}
