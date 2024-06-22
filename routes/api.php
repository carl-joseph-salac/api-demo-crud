<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Models\Product;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


/*
 Route to get the authenticated user's information
 This route is protected by the 'auth:sanctum' middleware,
 meaning the user must be authenticated via Sanctum to access it.
*/
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('products', ProductController::class);

Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);



/*
    // Group of routes protected by the 'auth:sanctum' middleware
    // All routes inside this group require the user to be authenticated via Sanctum.
    Route::middleware('auth:sanctum')->group(function() {
        // Define an API resource route for the ProductController
        // This will automatically create routes for index, show, store, update, and destroy methods.
        Route::apiResource('products', ProductController::class);
    });


    // Route to create a new Sanctum token for a user
    // This route does not require authentication (public route).
    Route::post('sanctum/token', function(Request $request) {
        $request->validate([ // Validate the request data to ensure 'email', 'password', and 'device_name' are provided
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $user = User::where('email', $request->email)->first(); // Retrieve the user by the provided email

        // Check if the user exists and if the provided password matches the stored hash
        // If the user does not exist or the password is incorrect, throw a validation exception
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Create a new Sanctum token for the user with the provided device name
        // Return the plain text token as the response
        return $user->createToken($request->device_name)->plainTextToken;
    });
*/
