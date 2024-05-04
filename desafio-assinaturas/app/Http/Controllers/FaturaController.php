<?php

namespace App\Http\Controllers;

use App\Library\Response;
use App\Library\Validation;
use App\Models\Assinatura;
use App\Models\Fatura;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FaturaController extends Controller
{
    /**
     * (Rota) Detalhes da Fatura
     *
     * @param integer $fatura_id
     * @return void
     */
    public function show(int $fatura_id)
    {
        try {
            $fatura = $this->findRegistro($fatura_id);

            $fatura = $fatura->load(['cadastro', 'assinatura']);

            Response::json($fatura, 200);
        } catch (\Exception $e) {
            Response::exception($e);
        }
    }

    /**
     * (Rota) Lista de Faturas
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
            $assinatura_id = (isset($fields['assinatura_id']) ? $fields['assinatura_id'] : "");
            $descricao = (isset($fields['descricao']) ? $fields['descricao'] : "");
            $data_vencimento = (isset($fields['vencimento']) ? $fields['vencimento'] : "");
            $valor = (isset($fields['valor']) ? $fields['valor'] : "");

            $query = Fatura::with(['cadastro', 'assinatura']);

            $query->when($id, function ($query) use ($id) {
                return $query->where('id', $id);
            })->when($cadastro_id, function ($query) use ($cadastro_id) {
                return $query->where('cadastro_id', $cadastro_id);
            })->when($assinatura_id, function ($query) use ($assinatura_id) {
                return $query->where('assinatura_id', $assinatura_id);
            })->when($descricao, function ($query) use ($descricao) {
                return $query->where('descricao', 'like', '%' . $descricao . '%');
            })->when($data_vencimento, function ($query) use ($data_vencimento) {
                return $query->where('data_vencimento', $data_vencimento);
            })->when($valor, function ($query) use ($valor) {
                return $query->where('valor', $valor);
            });

            //$data = $query->orderBy($sort, $order)->paginate($per_page);
            $data = $query->orderBy($sort, $order)->get();

            Response::json($data, 200);
        } catch (\Exception $e) {
            Response::exception($e);
        }
    }

    /**
     * (Rota) Inserir Fatura
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
                'assinatura_id' => ['required', 'exists:App\Models\Assinatura,id'],
                'descricao' => ['required', 'string'],
                'data_vencimento' => ['required', 'date'],
                'valor' => ['required', 'numeric']
            ]);

            $assinatura = Assinatura::find($fields['assinatura_id']);
            if (!empty($assinatura) && $assinatura->cadastro_id != $fields['cadastro_id']) {
                Response::json(['warning' => 'A assinatura selecionada é inválida'], 200);
            }

            Fatura::create($fields);

            Response::success();
        } catch (\Exception $e) {
            Response::exception($e);
        }
    }

    /**
     * (Rota) Alteração de Faturas
     *
     * @param Request $request
     * @param integer $fatura_id
     * @return void
     */
    public function update(Request $request, int $fatura_id)
    {
        try {
            $fields = $request->all();

            $fatura = $this->findRegistro($fatura_id);

            Validation::validate($fields, [
                'cadastro_id' => ['required', 'exists:App\Models\Cadastro,id'],
                'assinatura_id' => ['required', 'exists:App\Models\Assinatura,id'],
                'descricao' => ['required', 'string'],
                'data_vencimento' => ['required', 'date'],
                'valor' => ['required', 'numeric']
            ]);

            $assinatura = Assinatura::find($fields['assinatura_id']);
            if (!empty($assinatura) && $assinatura->cadastro_id != $fields['cadastro_id']) {
                Response::json(['warning' => 'A assinatura selecionada é inválida'], 200);
            }

            $fatura->update($fields);

            Response::success();
        } catch (\Exception $e) {
            Response::exception($e);
        }
    }

    /**
     * (Rota) Deletar Fatura
     *
     * @param integer $fatura_id
     * @return void
     */
    public function destroy(int $fatura_id)
    {
        try {
            $fatura = $this->findRegistro($fatura_id);

            $fatura = $fatura->load(['cadastro', 'assinatura']);

            if (!empty($fatura->assinatura) || !empty($fatura->cadastro)) {
                Response::json(['warning' => 'Fatura não pode ser deletada pois possui histórico de registros'], 400);
            }

            Response::success();
        } catch (\Exception $e) {
            Response::exception($e);
        }
    }


    /**
     * (Função) Pesquisa se fatura existe
     *
     * @param integer $id
     * @return boolean|object
     */
    private function findRegistro(int $id): bool|object
    {
        $data = Fatura::find($id);

        if (empty($data)) {
            Response::json(['warning' => 'Registro não encontrado'], 404);
        }

        return $data;
    }
}
