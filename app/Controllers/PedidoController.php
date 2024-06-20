<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\PedidoModel;

class PedidoController extends ResourceController
{
    protected PedidoModel $pedidoModel;
    public function __construct()
    {
        $this->pedidoModel = new PedidoModel();
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


        $pedidos = $this->pedidoModel->findAllPaginated($limit, ($page - 1) * $limit, $filters);

        $response = [
            "cabecalho" => [
                "status" => 200,
                "mensagem" => "Dados retornados com sucesso"
            ],
            "retorno" => $pedidos
        ];

        return $this->respond($response);
    }

    public function create()
    {
        try {
            $input = $this->request->getJSON(true);

            $data = $input['parametros'] ?? [];

            if ($this->pedidoModel->insert($data)) {
                return $this->respondCreated(['status' => 201, 'message' => 'Dados criados com sucesso']);
            } else {
                return $this->failValidationErrors($this->pedidoModel->errors());
                ;
            }

        } catch (\Exception $e) {

        }

    }

    public function read($id = null)
    {
        $pedido = $this->pedidoModel->find($id);
        if ($pedido) {
            $response = [
                "cabecalho" => [
                    "status" => 200,
                    "mensagem" => "Dados retornados com sucesso"
                ],
                "retorno" => $pedido
            ];
            return $this->respond($response);
        } else {
            return $this->failNotFound('Pedido não encontrado');
        }
    }

    public function update($id = null)
    {
        $pedido = $this->pedidoModel->find($id);

        $input = $this->request->getJSON(true);

        $data = $input['parametros'] ?? [];

        $this->pedidoModel->skipValidation(true);

        if (!$pedido) {
            return $this->failNotFound('Pedido não encontrado');
        }

        if (!$this->pedidoModel->update($id, $data)) {
            return $this->failValidationErrors($this->pedidoModel->errors());
        }

        $response = [
            "cabecalho" => [
                "status" => 200,
                "mensagem" => "Dados atualizado com sucesso"
            ],
            "retorno" => $pedido
        ];
        return $this->respond($response);
    }

    public function delete($id = null)
    {
        try {
            if (is_null($id)) {
                return $this->failValidationErrors('ID do pedido não fornecido.');
            }

            $pedido = $this->pedidoModel->find($id);
            if (!$pedido) {
                return $this->failNotFound('Pedido não encontrado.');
            }

            if ($this->pedidoModel->delete($id)) {
                $response = [
                    "cabecalho" => [
                        "status" => 200,
                        "mensagem" => "Dados deletados com sucesso"
                    ]
                ];
                return $this->respondDeleted($response);
            } else {
                return $this->failServerError('Erro ao deletar o pedido.');
            }
        } catch (Exception $e) {
            return $this->failServerError('Ocorreu um erro no servidor: ' . $e->getMessage());
        }
    }

}