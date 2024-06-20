<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\ProdutoModel;

class ProdutoController extends ResourceController
{
    protected ProdutoModel $produtoModel;
    public function __construct()
    {
        $this->produtoModel = new ProdutoModel();
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


        $produtos = $this->produtoModel->findAllPaginated($limit, ($page - 1) * $limit, $filters);

        $response = [
            "cabecalho" => [
                "status" => 200,
                "mensagem" => "Dados retornados com sucesso"
            ],
            "retorno" => $produtos
        ];

        return $this->respond($response);
    }

    public function create()
    {
        try {
            $input = $this->request->getJSON(true);

            $data = $input['parametros'] ?? [];

            if ($this->produtoModel->insert($data)) {
                return $this->respondCreated(['status' => 201, 'message' => 'Dados criados com sucesso']);
            } else {
                return $this->failValidationErrors($this->produtoModel->errors());
                ;
            }

        } catch (\Exception $e) {

        }
    }

    public function read($id = null)
    {
        $produto = $this->produtoModel->find($id);
        if ($produto) {
            $response = [
                "cabecalho" => [
                    "status" => 200,
                    "mensagem" => "Dados retornados com sucesso"
                ],
                "retorno" => $produto
            ];
            return $this->respond($response);
        } else {
            return $this->failNotFound('Produto não encontrado');
        }
    }

    public function update($id = null)
    {
        $produto = $this->produtoModel->find($id);

        $input = $this->request->getJSON(true);

        $data = $input['parametros'] ?? [];

        $this->produtoModel->skipValidation(true);

        if (!$produto) {
            return $this->failNotFound('Produto não encontrado');
        }

        if (!$this->produtoModel->update($id, $data)) {
            return $this->failValidationErrors($this->produtoModel->errors());
        }

        $response = [
            "cabecalho" => [
                "status" => 200,
                "mensagem" => "Dados atualizado com sucesso"
            ],
            "retorno" => $produto
        ];
        return $this->respond($response);
    }

    public function delete($id = null)
    {
        if ($this->produtoModel->deleteProduto($id)) {
            return $this->respondDeleted(['status' => 200, 'message' => 'Dados deletados com sucesso']);
        } else {
            return $this->failNotFound('Produto não encontrado');
        }
    }
}