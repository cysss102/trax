<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TripRequest;
use App\Services\TripService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class TripController extends Controller
{
    public function __construct(private TripService $tripService)
    {

    }

    public function index(): JsonResponse
    {
        return response()->json(['data' => $this->tripService->getAllTrips()], Response::HTTP_OK);
    }

    public function store(TripRequest $request): JsonResponse
    {
        $this->tripService->addTrip($request);

        return response()->json(['message' => 'Added'], Response::HTTP_CREATED);
    }
}
