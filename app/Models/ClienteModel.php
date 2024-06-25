<?php

namespace App\Models;

use App\Enums\Status;
use CodeIgniter\Model;

class ClienteModel extends Model
{
    protected $table = 'clientes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['cpf_cnpj', 'nome_razao_social', 'status', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $validationRules = [
        'cpf_cnpj' => 'required|is_unique[clientes.cpf_cnpj]',
        'nome_razao_social' => 'required|string|min_length[3]|max_length[255]'
    ];

    protected $validationMessages = [
        'cpf_cnpj' => [
            'required' => 'O campo CPF/CNPJ é obrigatório.',
            'is_unique' => 'Este CPF/CNPJ já está cadastrado.'
        ],
        'nome_razao_social' => [
            'required' => 'O campo Nome/Razão Social é obrigatório.'
        ]
    ];


    public function find($id = null)
    {
        $row = parent::find($id);
        if ($row) {
            $row['status'] = Status::getText($row['status']);
        }
        return $row;
    }

    public function findAll(int $limit = 0, int $offset = 0)
    {
        $builder = $this->db->table($this->table);
        $builder->where('status', Status::Ativo);
        $results = $builder->get()->getResultArray();

        foreach ($results as &$row) {
            $row['status'] = Status::getText($row['status']);
        }

        return $results;
    }
    public function deleteCliente($id)
    {
        return $this->update($id, ['status' => Status::Inativo]);
    }

    public function findAllPaginated($limit = 0, $offset = 0, $filters = [])
    {
        $builder = $this->builder();

        $builder->where('status', Status::Ativo);

        if (!empty($filters)) {
            foreach ($filters as $key => $value) {
                $builder->like($key, $value);
            }
        }

        $query = $builder->limit($limit, $offset)
            ->get();

        $results = $query->getResultArray();

        foreach ($results as &$row) {
            $row['status'] = Status::getText($row['status']);
        }

        return $results;
    }
}