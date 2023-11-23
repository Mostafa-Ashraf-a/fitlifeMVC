<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="FitLife",
 *      description="FitLife API description",
 *      @OA\Contact(
 *          email="mOmar@smart.sa"
 *      ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 */

/**
 *
 *  @OA\Server(
 *      url="https://localhost:8000/api/v1",
 *      description="FitLife API description"
 * )
 */


/**
 * @OA\SecurityScheme(
 *     type="oauth2",
 *     description="Use a global client_id / client_secret and your username / password combo to obtain a token",
 *     name="Password Based",
 *     in="header",
 *     scheme="https",
 *     securityScheme="Password Based",
 *     @OA\Flow(
 *         flow="password",
 *         authorizationUrl="/oauth/authorize",
 *         tokenUrl="/oauth/token",
 *         refreshUrl="/oauth/token/refresh",
 *         scopes={}
 *     )
 * )
 */

/**
 * @OA\OpenApi(
 *   security={
 *     {
 *       "oauth2": {"read:oauth2"},
 *     }
 *   }
 * )
 */

class APIController extends Controller
{

}
