<?php

namespace App\Http\Controllers;

use App\Library\Response;
use App\Library\Validation;
use App\Models\Cadastro;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class CadastroController extends Controller
{
    /**
     * (Rota) Detalhes do cadastro
     *
     * @param integer $cadastro_id
     * @return void
     */
    public function show(int $cadastro_id)
    {
        try {
            $cadastro = $this->findRegistro($cadastro_id);

            $cadastro = $cadastro->load(['assinatura', 'fatura']);

            Response::json($cadastro, 200);
        } catch (\Exception $e) {
            Response::exception($e);
        }
    }

    /**
     * (Rota) Lista de cadastros
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
            $codigo = (isset($fields['codigo']) ? $fields['codigo'] : "");
            $nome = (isset($fields['nome']) ? $fields['nome'] : "");
            $email = (isset($fields['email']) ? $fields['email'] : "");
            $telefone = (isset($fields['telefone']) ? $fields['telefone'] : "");

            $query = Cadastro::with(['assinatura', 'fatura']);

            $query->when($id, function ($query) use ($id) {
                return $query->where('id', $id);
            })->when($codigo, function ($query) use ($codigo) {
                return $query->where('codigo', $codigo);
            })->when($nome, function ($query) use ($nome) {
                return $query->where('nome', 'like', '%' . $nome . '%');
            })->when($email, function ($query) use ($email) {
                return $query->where('email', $email);
            })->when($telefone, function ($query) use ($telefone) {
                return $query->where('telefone', 'like', '%' . $telefone . '%');
            });

            //$data = $query->orderBy($sort, $order)->paginate($per_page);
            $data = $query->orderBy($sort, $order)->get();

            Response::json($data, 200);
        } catch (\Exception $e) {
            Response::exception($e);
        }
    }

    /**
     * (Rota) Inserir Cadastros
     * 
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        try {
            $fields = $request->all();

            Validation::validate($fields, [
                'nome' => ['required', 'string'],
                'email' => ['required', 'email', 'unique:' . Cadastro::class],
                'telefone' => ['required', 'string']
            ]);

            $fields['codigo'] = $this->generateUuid();

            Cadastro::create($fields);

            Response::success();
        } catch (\Exception $e) {
            Response::exception($e);
        }
    }

    /**
     * (Rota) Alteração de Cadastros
     *
     * @param Request $request
     * @param integer $cadastro_id
     * @return void
     */
    public function update(Request $request, int $cadastro_id)
    {
        try {
            $fields = $request->all();

            $cadastro = $this->findRegistro($cadastro_id);

            Validation::validate($fields, [
                'nome' => ['required', 'string'],
                'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($cadastro->id)],
                'telefone' => ['required', 'string']
            ]);

            if (array_key_exists('codigo', $fields)) {
                unset($fields['codigo']);
            }

            $cadastro->update($fields);

            Response::success();
        } catch (\Exception $e) {
            Response::exception($e);
        }
    }

    /**
     * (Rota) Deletar Cadastro
     *
     * @param integer $cadastro_id
     * @return void
     */
    public function destroy(int $cadastro_id)
    {
        try {
            $cadastro = $this->findRegistro($cadastro_id);

            $cadastro = $cadastro->load(['assinatura', 'fatura']);

            if (!empty($cadastro->assinatura) || !empty($cadastro->fatura)) {
                Response::json(['warning' => 'Cadastro não pode ser deletado pois possui histórico de registros'], 400);
            }
            
            $cadastro->delete();

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
        $data = Cadastro::find($id);

        if (empty($data)) {
            Response::json(['warning' => 'Registro não encontrado'], 404);
        }

        return $data;
    }

    /**
     * (Função) que retorna um uuid aleatório
     *
     * @return void
     */
    private static function generateUuid()
    {
        return Str::uuid();
    }
}
