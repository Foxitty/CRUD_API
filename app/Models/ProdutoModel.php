<?php

namespace App\Models;

use App\Enums\Status;
use CodeIgniter\Model;

class ProdutoModel extends Model
{
    protected $table = 'produtos';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nome', 'preco', 'status', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'nome' => 'required',
        'preco' => 'required'
    ];

    protected $validationMessages = [
        'nome' => [
            'required' => 'O campo nome é obrigatório.'
        ],
        'preco' => [
            'required' => 'O campo preço é obrigatório.'
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
    public function deleteProduto($id)
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