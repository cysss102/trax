<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CarRequest;
use App\Services\CarService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CarController extends Controller
{
    public function __construct(private CarService $carService)
    {
    }

    public function index(): JsonResponse
    {
        return response()->json(['data' => $this->carService->getAllCars()], Response::HTTP_OK);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json(['data' => $this->carService->getCarById($id)], Response::HTTP_OK);
    }

    public function store(CarRequest $request): JsonResponse
    {
        $this->carService->addCar($request);

        return response()->json(['message' => 'Added'], Response::HTTP_CREATED);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->carService->deleteModel($id);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
