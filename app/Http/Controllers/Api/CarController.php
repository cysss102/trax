<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CarRequest;
use App\Services\CarService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CarController extends Controller
{
    public function __construct(private CarService $carService)
    {
    }

    public function index(): JsonResponse
    {
        return response()->json(['data' => $this->carService->getAllCars()], 200);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json(['data' => $this->carService->getCarById($id)], 200);
    }

    public function store(CarRequest $request): JsonResponse
    {
        try {
            $this->carService->addCar($request);

            return response()->json(['message' => 'added'], 201);
        } catch (\Exception $exception) {
            throw new HttpException(400, "Invalid data");
        }
    }

    public function destroy(int $id): JsonResponse
    {
        $this->carService->deleteModel($id);

        return response()->json(['message' => 'deleted'], 204);
    }
}
