<?php

namespace App\Controllers;

use CodeIgniter\Database\Exceptions\DatabaseException;

class Home extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        try {
            if ($db->connect()) {
                echo "Conexão com o banco de dados bem-sucedida!";
            }
        } catch (DatabaseException $e) {
            echo "Erro ao conectar com o banco de dados: " . $e->getMessage();
        }
    }
}