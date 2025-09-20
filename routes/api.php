<?php
use App\Http\Controllers\Api\CheckinApiController;

Route::post('/checkins', [CheckinApiController::class, 'store'])->middleware('auth:sanctum'); 
// atau custom middleware yang memeriksa header X-DEVICE-TOKEN

?>