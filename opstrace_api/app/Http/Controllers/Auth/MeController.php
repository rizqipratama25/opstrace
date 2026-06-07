<?php

namespace App\Http\Controllers\Auth;

use App\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\User;
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

    public function editMeInfo(Request $request) {
        try {
            if (!$request->user()) {
                return $this->unauthorizedResponse('Unauthorized');
            }

            $validated = $request->validate([
                "telegram_username" => "nullable|string|max:255",
            ]);

            $request->user()->update($validated);

            return $this->successResponse($request->user(), 'User data updated successfully');
        } catch (Exception $e) {
            return $this->errorResponse('Failed to update user data', 500, $e->getMessage());
        }
    }
}
