<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="Laravel Admin App Documentation",
     *      description="Laravel Admin App OpenApi description",
     *      @OA\Contact(
     *          email="abiolafakorede@gmail.com"
     *      ),
     * )
     *
     *  @OA\Server(
     *      url="http://localhost:8000/api",
     *      description="Laravel Admin API Server"
     *  )   description="L5 Swagger OpenApi Server"
     *
     * @OA\SecurityScheme(
     *     type="http",
     *     scheme="bearer",
     *     securityScheme="bearerAuth",
     * )
     */

}
