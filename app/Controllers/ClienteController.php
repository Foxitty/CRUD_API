<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\ClienteModel;

class ClienteController extends ResourceController
{
    protected ClienteModel $clienteModel;
    public function __construct()
    {
        $this->clienteModel = new ClienteModel();
    }
    public function list()
    {

        $params = $this->request->getGet();

        $limit = isset($params['limit']) ? (int) $params['limit'] : 10;
        $page = isset($params['page']) ? (int) $params['page'] : 1;

        $filters = [];
        foreach ($params as $key => $value) {
            if (!in_array($key, ['limit', 'page'])) {
                $filters[$key] = $value;
            }
        }


        $clientes = $this->clienteModel->findAllPaginated($limit, ($page - 1) * $limit, $filters);

        $response = [
            "cabecalho" => [
                "status" => 200,
                "mensagem" => "Dados retornados com sucesso"
            ],
            "retorno" => $clientes
        ];

        return $this->respond($response);
    }

    public function create()
    {
        try {
            $input = $this->request->getJSON(true);

            $data = $input['parametros'] ?? [];

            if ($this->clienteModel->insert($data)) {
                return $this->respondCreated(['status' => 201, 'message' => 'Dados criados com sucesso']);
            } else {
                return $this->failValidationErrors($this->clienteModel->errors());
                ;
            }

        } catch (\Exception $e) {

        }

    }

    public function read($id = null)
    {
        $cliente = $this->clienteModel->find($id);
        if ($cliente) {
            $response = [
                "cabecalho" => [
                    "status" => 200,
                    "mensagem" => "Dados retornados com sucesso"
                ],
                "retorno" => $cliente
            ];
            return $this->respond($response);
        } else {
            return $this->failNotFound('Cliente não encontrado');
        }
    }

    public function update($id = null)
    {
        $input = $this->request->getJSON(true);

        $data = $input['parametros'] ?? [];

        $this->clienteModel->skipValidation(true);

        if ($this->clienteModel->update($id, $data)) {
            $cliente = $this->clienteModel->find($id);
            $response = [
                "cabecalho" => [
                    "status" => 200,
                    "mensagem" => "Dados atualizado com sucesso"
                ],
                "retorno" => $cliente
            ];
            return $this->respond($response);
        } else {
            return $this->failValidationErrors($this->clienteModel->errors());
        }
    }

    public function delete($id = null)
    {
        if ($this->clienteModel->deleteCliente($id)) {
            return $this->respondDeleted(['status' => 200, 'message' => 'Dados deletados com sucesso']);
        } else {
            return $this->failNotFound('Cliente não encontrado');
        }
    }
}