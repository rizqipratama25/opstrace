<?php

namespace App\Http\Controllers\Auth;

use App\ApiResponse;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class MeController extends Controller
{
    use ApiResponse;

    public function me(Request $request) {
        try {
            if (!$request->user()) {
                return $this->unauthorizedResponse('Unauthorized');
            }

            return $this->successResponse($request->user(), 'User data retrieved successfully');
        } catch (Exception $e) {
            return $this->errorResponse('Failed to retrieve user data', 500, $e->getMessage());
        }
    }
}
