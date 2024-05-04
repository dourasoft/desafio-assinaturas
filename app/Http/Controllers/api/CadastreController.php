<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CadastreRequest;
use App\Models\Cadastre;


/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="My OpenApi Documentation",
 *      description="My OpenApi description",
 *      @OA\Contact(
 *          email="markusmak@gmail.com"
 *      ),
 *      @OA\License(
 *          name="Proprietary",
 *          url=""
 *      )
 * )
 *
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="My API Server"
 * )
 */
class CadastreController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/cadastre",
     *      operationId="getCadastres",
     *      tags={"Cadastres"},
     *      summary="Get list of cadastres",
     *      description="Returns list of cadastres",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     */
    public function index()
    {
        try {

            return response_api(Cadastre::with("signature")->get(), true, '');

        } catch (\Throwable $th) {
            
            return response_api([], false, $th->getMessage(), 400);

        }
    }

    /**
     * @OA\Post(
     *      path="/api/cadastre",
     *      summary="Create a new cadastre",
     *      description="Create a new cadastre entry in the database by providing the required information.",
     *      tags={"Cadastres"},
     *      @OA\RequestBody(
     *          required=true,
     *          description="Cadastre data to be stored",
     *          @OA\JsonContent(ref="#/components/schemas/CadastreRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation. Returns the newly created cadastre data.",
     *          @OA\JsonContent(
     *              ref="#/components/schemas/CadastreRequest"
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad request or validation error.",
     *          @OA\JsonContent(
     *              example={"error": "Validation error message"}
     *          )
     *      )
     * )
     */
    public function store(CadastreRequest $request)
    {
        try {
           
            $request->merge(['cod' => random_int(1000000000, 9999999999)]);
            $cadastre = Cadastre::create($request->all());
            return response_api($cadastre, true, '');

        } catch (\Throwable $th) {
            
            return response_api([], false, $th->getMessage(), 400);

        }
    }

    /**
     * @OA\Get(
     *      path="/api/cadastre/{id}",
     *      summary="Get a cadastre by ID",
     *      description="Retrieve the cadastre details by providing its ID.",
     *      tags={"Cadastres"},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID of the cadastre to be retrieved",
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation. Returns the cadastre data.",
     *          @OA\JsonContent(
     *              ref="#/components/schemas/CadastreRequest"
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Cadastre not found.",
     *          @OA\JsonContent(
     *              example={"error": "Cadastre not found"}
     *          )
     *      )
     * )
     */
    public function show(string $id)
    {
        try {
           
            $cadastre = Cadastre::with("signature")->find($id);

            if (!$cadastre) {
                return response_api([], false, 'not found', 400);
            }

            return response_api($cadastre, true, '');

        } catch (\Throwable $th) {
            
            return response_api([], false, $th->getMessage(), 400);

        }
       
    }


    /**
     * @OA\Put(
     *      path="/api/cadastre/{id}",
     *      summary="Update a cadastre by ID",
     *      description="Update the information of a cadastre by providing its ID.",
     *      tags={"Cadastres"},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID of the cadastre to be updated",
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          description="Updated cadastre data",
     *          @OA\JsonContent(ref="#/components/schemas/CadastreRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation. Returns the updated cadastre data.",
     *          @OA\JsonContent(
     *              ref="#/components/schemas/CadastreRequest"
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Cadastre not found.",
     *          @OA\JsonContent(
     *              example={"error": "Cadastre not found"}
     *          )
     *      )
     * )
     */
    public function update(CadastreRequest $request, string $id)
    {

        try {
           
            $cadastre = Cadastre::find($id);

            if (!$cadastre) {
                return response_api([], false, 'not found', 400);
            }

            $cadastre->update($request->all());

            return response_api($cadastre, true, '');

        } catch (\Throwable $th) {
            
            return response_api([], false, $th->getMessage(), 400);

        }
    }


    /**
     *
     * @OA\Delete(
     *      path="/api/cadastre/{id}",
     *      summary="Delete a cadastre by ID",
     *      description="Delete a cadastre from the database by providing its ID.",
     *      tags={"Cadastres"},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID of the cadastre to be deleted",
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Successful operation. No content.",
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Cadastre not found.",
     *          @OA\JsonContent(
     *              example={"error": "Cadastre not found"}
     *          )
     *      )
     * )
     */
    public function destroy(string $id, $force = false)
    {

        try {
           
            $cadastre = Cadastre::find($id);

            if (!$cadastre) {
                return response_api([], false, 'not found', 400);
            }

            $cadastre->delete();

            return response_api([], true, '');

        } catch (\Throwable $th) {
            
            return response_api([], false, $th->getMessage(), 400);

        }
    }
}
