<?php

namespace App\Models;

use App\Enums\StatusPedido;
use CodeIgniter\Model;

class PedidoModel extends Model
{
    protected $table = 'pedidos';
    protected $primaryKey = 'id';
    protected $allowedFields = ['cliente_id', 'produto_id', 'status', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'cliente_id' => 'required',
        'produto_id' => 'required',
    ];

    public function find($id = null)
    {
        if (is_null($id)) {
            return null;
        }

        $builder = $this->builder();
        $builder->select('pedidos.*, clientes.id as cliente_id, clientes.cpf_cnpj, clientes.nome_razao_social, produtos.id as produto_id, produtos.nome, produtos.preco');
        $builder->join('clientes', 'pedidos.cliente_id = clientes.id');
        $builder->join('produtos', 'pedidos.produto_id = produtos.id');
        $builder->where('pedidos.id', $id);

        $result = $builder->get()->getRowArray();

        if ($result) {
            $pedido = [
                'id' => $result['id'],
                'cliente' => [
                    'id' => $result['cliente_id'],
                    'cpf_cnpj' => $result['cpf_cnpj'],
                    'nome_razao_social' => $result['nome_razao_social']
                ],
                'produto' => [
                    'id' => $result['produto_id'],
                    'nome' => $result['nome'],
                    'preco' => $result['preco']
                ],
                'status' => StatusPedido::getText($result['status']),
                'created_at' => $result['created_at'],
                'updated_at' => $result['updated_at']
            ];

            return $pedido;
        }

        return null;
    }


    public function findAll(int $limit = 0, int $offset = 0)
    {
        $builder = $this->db->table($this->table);
        $results = $builder->get()->getResultArray();

        foreach ($results as &$row) {
            $row['status'] = StatusPedido::getText($row['status']);
        }

        return $results;
    }
    public function findAllPaginated($limit = 0, $offset = 0, $filters = [])
    {
        $builder = $this->builder();
        $builder->select('pedidos.*, clientes.id as cliente_id, clientes.cpf_cnpj, clientes.nome_razao_social, produtos.id as produto_id, produtos.nome, produtos.preco');
        $builder->join('clientes', 'pedidos.cliente_id = clientes.id');
        $builder->join('produtos', 'pedidos.produto_id = produtos.id');

        if (!empty($filters)) {
            foreach ($filters as $key => $value) {
                $field = 'pedidos.' . $key;

                if (is_string($value)) {
                    $builder->like($field, $value);
                } else {
                    $builder->where($field, $value);
                }
            }
        }

        $query = $builder->limit($limit, $offset)->get();
        $results = $query->getResultArray();

        $pedidos = [];

        foreach ($results as $row) {
            $pedidos[] = [
                'id' => $row['id'],
                'cliente' => [
                    'id' => $row['cliente_id'],
                    'cpf_cnpj' => $row['cpf_cnpj'],
                    'nome_razao_social' => $row['nome_razao_social']
                ],
                'produto' => [
                    'id' => $row['produto_id'],
                    'nome' => $row['nome'],
                    'preco' => $row['preco']
                ],
                'status' => StatusPedido::getText($row['status']),
                'created_at' => $row['created_at'],
                'updated_at' => $row['updated_at']
            ];
        }

        return $pedidos;
    }
}