<?php

namespace App\Http\Controllers\Auth;

use App\ApiResponse;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    use ApiResponse;

    public function logout(Request $request) {
        try {
            $request->user()->currentAccessToken()->delete();
    
            return $this->successResponse(null, 'Logout successful');
        } catch (Exception $e) {
            return $this->errorResponse('Failed to logout', 500, $e->getMessage());
        }
    }
}
