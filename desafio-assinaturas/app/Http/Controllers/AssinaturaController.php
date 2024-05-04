<?php

namespace App\Http\Controllers;

use App\Library\Response;
use App\Library\Validation;
use App\Models\Assinatura;
use Illuminate\Http\Request;

class AssinaturaController extends Controller
{
    /**
     * (Rota) Detalhes da Assinatura
     *
     * @param integer $assinatura_id
     * @return void
     */
    public function show(int $assinatura_id)
    {
        try {
            $assinatura = $this->findRegistro($assinatura_id);

            $assinatura = $assinatura->load('cadastro');

            Response::json($assinatura, 200);
        } catch (\Exception $e) {
            Response::exception($e);
        }
    }

    /**
     * (Rota) Lista de Assinaturas
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        try {
            $fields = $request->all();

            //Parametros default para listagem
            $per_page = (isset($fields['per_page']) ? $fields['per_page'] : env("PER_PAGE_DEFAULT", 5));
            $sort = (isset($fields['sort']) ? $fields['sort'] : env("SORT_BY_DEFAULT", "id"));
            $order = (isset($fields['order']) ? $fields['order'] : env("ORDER_BY_DEFAULT", "ASC"));

            //Filtros
            $id = (isset($fields['id']) ? $fields['id'] : "");
            $cadastro_id = (isset($fields['cadastro_id']) ? $fields['cadastro_id'] : "");
            $valor = (isset($fields['valor']) ? $fields['valor'] : "");
            $flag_assinado = (isset($fields['flag_assinado']) ? $fields['flag_assinado'] : "");
            $data_vencimento = (isset($fields['data_vencimento']) ? $fields['data_vencimento'] : "");

            $query = Assinatura::with('cadastro');

            $query->when($id, function ($query) use ($id) {
                return $query->where('id', $id);
            })->when($cadastro_id, function ($query) use ($cadastro_id) {
                return $query->where('cadastro_id', $cadastro_id);
            })->when($valor, function ($query) use ($valor) {
                return $query->where('valor', $valor);
            })->when($flag_assinado, function ($query) use ($flag_assinado) {
                return $query->where('flag_assinado', $flag_assinado);
            })->when($data_vencimento, function ($query) use ($data_vencimento) {
                return $query->where('data_vencimento', $data_vencimento);
            });

            //$data = $query->orderBy($sort, $order)->paginate($per_page);
            $data = $query->orderBy($sort, $order)->get();

            Response::json($data, 200);
        } catch (\Exception $e) {
            Response::exception($e);
        }
    }

    /**
     * (Rota) Inserir Assinaturas
     * 
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        try {
            $fields = $request->all();

            Validation::validate($fields, [
                'cadastro_id' => ['required', 'exists:App\Models\Cadastro,id'],
                'descricao' => ['required', 'string'],
                'valor' => ['required', 'numeric'],
                'data_vencimento' => ['required', 'date'],
                'flag_assinado' => ['required', 'string'],
            ]);

            Assinatura::create($fields);

            Response::success();
        } catch (\Exception $e) {
            Response::exception($e);
        }
    }

    /**
     * (Rota) Alteração de Assinaturas
     *
     * @param Request $request
     * @param integer $assinatura_id
     * @return void
     */
    public function update(Request $request, int $assinatura_id)
    {
        try {
            $fields = $request->all();

            $assinatura = $this->findRegistro($assinatura_id);

            Validation::validate($fields, [
                'cadastro_id' => ['required', 'exists:App\Models\Cadastro,id'],
                'descricao' => ['required', 'string'],
                'valor' => ['required', 'numeric'],
                'data_vencimento' => ['required', 'date'],
                'flag_assinado' => ['required', 'string'],
            ]);

            $assinatura->update($fields);

            Response::success();
        } catch (\Exception $e) {
            Response::exception($e);
        }
    }

    /**
     * (Rota) Deletar Assinatura
     *
     * @param integer $assinatura_id
     * @return void
     */
    public function destroy(int $assinatura_id)
    {
        try {
            $assinatura = $this->findRegistro($assinatura_id);            

            $assinatura = $assinatura->load('fatura');

            if (!empty($assinatura->fatura)) {
                Response::json(['warning' => 'Assinatura não pode ser deletado pois possui histórico de registros'], 400);
            }

            $assinatura->delete();

            Response::success();
        } catch (\Exception $e) {
            Response::exception($e);
        }
    }


    /**
     * (Função) Pesquisa se cadastro existe
     *
     * @param integer $id
     * @return boolean|object
     */
    private static function findRegistro(int $id): bool|object
    {
        $data = Assinatura::find($id);

        if (empty($data)) {
            Response::json(['warning' => 'Registro não encontrado'], 404);
        }

        return $data;
    }
}
