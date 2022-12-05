<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TripRequest;
use App\Services\TripService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;

class TripController extends Controller
{
    public function __construct(private TripService $tripService)
    {

    }

    public function index(): JsonResponse
    {
        return response()->json(['data' => $this->tripService->getAllTrips()], 200);
    }

    public function store(TripRequest $request): JsonResponse
    {
        try {
            $this->tripService->addTrip($request);

            return response()->json(['message' => 'added'], 201);
        } catch (\Exception $exception) {
            throw new HttpException(400, "Invalid data");
        }
    }
}
