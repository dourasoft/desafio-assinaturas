<?php


class Customs
{
    private $user;
    private $cadastro;
    private $assinatura;
    private $fatura;

    public function __construct()
    {
        $this->user = new User();
        $this->cadastro = new Cadastros();
        $this->assinatura = new Assinaturas();
        $this->fatura = new Faturas();
    }

    public function get(array $package)
    {
        /**
         * USER
         */
        if ($package['controller'] == "LoginUser") {
            $data = $package['data'];
            return $this->user->login($data);
        }

        if ($package['controller'] == "LogoutUser") {
            return $this->user->logout();
        }

        /**
         * CADASTROS
         */
        if ($package['controller'] == "IndexCadastro") {
            return $this->cadastro->index();
        }

        if ($package['controller'] == "ShowCadastro") {
            $id = intval($package['data']['id']);
            return $this->cadastro->show($id);
        }

        if ($package['controller'] == "DeleteCadastro") {
            $id = intval($package['data']['id']);
            return $this->cadastro->delete($id);
        }

        if ($package['controller'] == "StoreCadastro") {
            $data = $package['data'];
            return $this->cadastro->store($data);
        }

        if ($package['controller'] == "UpdateCadastro") {
            $data = $package['data'];
            return $this->cadastro->update($data);
        }

        /**
         * ASSINATURAS
         */
        if ($package['controller'] == "IndexAssinatura") {
            return $this->assinatura->index();
        }

        if ($package['controller'] == "ShowAssinatura") {
            $id = intval($package['data']['id']);
            return $this->assinatura->show($id);
        }

        if ($package['controller'] == "DeleteAssinatura") {
            $id = intval($package['data']['id']);
            return $this->assinatura->delete($id);
        }

        if ($package['controller'] == "StoreAssinatura") {
            $package['data']['valor'] = str_replace([".", ","], ["", "."], $package['data']['valor']);
            $package['data']['data_vencimento'] = date("Y-m-d", strtotime($package['data']['data_vencimento']));
            $data = $package['data'];
            return $this->assinatura->store($data);
        }

        if ($package['controller'] == "UpdateAssinatura") {
            $package['data']['valor'] = str_replace([".", ","], ["", "."], $package['data']['valor']);
            $package['data']['data_vencimento'] = date("Y-m-d", strtotime($package['data']['data_vencimento']));
            $data = $package['data'];
            return $this->assinatura->update($data);
        }

        /**
         * FATURAS
         */
        if ($package['controller'] == "IndexFatura") {
            return $this->fatura->index();
        }

        if ($package['controller'] == "ShowFatura") {
            $id = intval($package['data']['id']);
            return $this->fatura->show($id);
        }

        if ($package['controller'] == "DeleteFatura") {
            $id = intval($package['data']['id']);
            return $this->fatura->delete($id);
        }

        if ($package['controller'] == "StoreFatura") {
            $package['data']['valor'] = str_replace([".", ","], ["", "."], $package['data']['valor']);
            $package['data']['data_vencimento'] = date("Y-m-d", strtotime($package['data']['data_vencimento']));
            $data = $package['data'];
            return $this->fatura->store($data);
        }

        if ($package['controller'] == "UpdateFatura") {
            $package['data']['valor'] = str_replace([".", ","], ["", "."], $package['data']['valor']);
            $package['data']['data_vencimento'] = date("Y-m-d", strtotime($package['data']['data_vencimento']));
            $data = $package['data'];
            return $this->fatura->update($data);
        }
    }
}
