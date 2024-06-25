Sistema de Pedidos com CRUD (CodeIgniter 4)
===

 Este projeto é um exemplo de um sistema de pedidos implementado utilizando o framework CodeIgniter 4. Ele inclui operações básicas de CRUD (Create, Read, Update, Delete) para pedidos, clientes e produtos, usando um banco de dados MySQL.

## Pré-requisitos
 Antes de começar, certifique-se de ter instalado em seu ambiente de desenvolvimento:
    
* PHP 7.4 
* MySQL

## Instalação
**Clonar o repositório:**

    git clone git@github.com:Foxitty/CRUD_API.git

**Instale as Dependências**

 Certifique-se de ter as dependências necessárias instaladas via Composer:
    
    composer require firebase/php-jwt

**Configurar o ambiente:**
    
 Copie o arquivo .env.example para .env e configure-o com suas credenciais de banco de dados:
 
 Configure as variáveis de ambiente necessárias no arquivo .env (como banco de dados, URL base, etc).

**Executar as migrações do banco de dados:**
    
 Execute as migrações para criar as tabelas necessárias no banco de dados:
    
    php spark migrate
    
 Isso criará as tabelas pedidos, clientes, produtos e suas respectivas estruturas no banco de dados configurado.

**Iniciar o servidor de desenvolvimento:**

 Use o comando abaixo para iniciar o servidor de desenvolvimento do CodeIgniter:

    php spark serve

## Testando com Postman

**Instale o Postman**

 Se ainda não tiver, instale o Postman em seu ambiente de desenvolvimento.

**Configuração de Requisições no Postman**

* Abra o Postman e crie uma nova requisição para o endpoint de login.

* Método: POST

* URL: http://seu_servidor/api/login exemplo: http://localhost:8080/api/login

    Na aba Body: Selecione raw e escolha JSON (application/json). Insira as credenciais válidas para o login:
    
    {
        "email": "teste_auth@gmail.com",
        "password": "12345"
    }
    
    Envie a requisição. O servidor deve retornar um JSON contendo o token JWT:
    
    {
        "token": "seu_token_jwt_aqui"
    }
    
    Esse token tem validade de 1 dia. Use esse Token no passo abaixo.

## Autenticando Requisições Protegidas

Para acessar rotas protegidas que requerem autenticação, adicione o token JWT obtido como um cabeçalho Authorization na requisição .

* Crie uma nova requisição para uma rota dos endpoints abaixo.

* Método: GET, POST, ou outro conforme a sua implementação.

* URL: http://seu_servidor/api/rota_protegida exemplo: http://localhost:8080/api/produtos

* Em Authorization, depois Auth Token selecione Bearer Token e em token, cole o token gerado acima.

Certifique-se de configurar corretamente o JWT_SECRET no seu arquivo .env. Pode o JWT_SECRET estático do .env_example

## Uso

## Endpoints Disponíveis

**A API possui os seguintes endpoints principais:**

* Em cada Rota ir em Authorization, depois Auth Token selecione Bearer Token e em token, cole o token gerado acima.

**Clientes**

* GET /api/clientes: Retorna todos os clientes cadastrados.

* POST /api/cliente/novo: Cria um novo cliente. Campos: cpf_cnpj, nome_razao_social, status é opcional pois o default é 1 (1 = ativo e 0 = inativo).
  
 Na aba Body: Selecione raw e escolha JSON (application/json). Insira:

      {
      "parametros": {
          "cpf_cnpj": "78.404.961/0001-59",
          "nome_razao_social": "João da Silva" 
          }
      } 
         

* GET /api/cliente/{id}: Retorna um cliente específico pelo ID.

* PUT /api/cliente/{id}/editar: Atualiza um cliente existente pelo ID. Campos: cpf_cnpj, nome_razao_social, status é opcional pois o default é 1 (1 = ativo e 0 = inativo).

Na aba Body: Selecione raw e escolha JSON (application/json). Insira:

         {
         "parametros": {
             "cpf_cnpj": "78.404.961/0001-59",
             "nome_razao_social": "João da Silva Oliveira"
             }
         }

* PUT /api/cliente/{id}/deletar: Faz a remoção lógica de um cliente pelo ID colocando status = 0 (inativo).

*Parâmetros de Paginação e Filtro*
* GET /api/clientes?limit={limit}&page={page}&nome_razao_social={nome_razao_social}: Retorna pedidos paginados com limite e página especificados. Você pode opcionalmente filtrar por cpf_cnpj e/ou nome_razao_social.


**Produtos**

* GET /api/produtos: Retorna todos os produtos cadastrados.

* POST /api/produto/novo: Cria um novo produto. Campos: nome, preco, status é opcional pois o default é 1 (1 = ativo e 0 = inativo).
  
   Na aba Body: Selecione raw e escolha JSON (application/json). Insira:

      {
      "parametros": {
          "nome": "chave",
          "preco": "14.00"
          }
      }

* GET /api/produto/{id}: Retorna um produto específico pelo ID.

* PUT /api/produto/{id}/editar: Atualiza um produto existente pelo ID. Campos: nome, preco, status é opcional pois o default é 1 (1 = ativo e 0 = inativo).
  
 Na aba Body: Selecione raw e escolha JSON (application/json). Insira:
 
      {
      "parametros": {
          "nome": "chave de fenda",
          "preco": "18.00"
          }
      }

* PUT /api/produto/{id}/deletar: Faz a remoção lógica de um produto pelo ID colocando status = 0 (inativo).

*Parâmetros de Paginação e Filtro*
* GET /api/produtos?limit={limit}&page={page}&nome={nome}: Retorna pedidos paginados com limite e página especificados. Você pode opcionalmente filtrar por nome e/ou preco.


**Pedidos**

* GET /api/pedidos: Retorna todos os pedidos cadastrados.

* POST /api/pedido/novo: Cria um novo pedido. Campos: cliente_id, produto_id, status é opcional pois o default é 0 (0 = Em Aberto, 1 = Pago e 2 = Cancelado).
<<<<<<< HEAD

Na aba Body: Selecione raw e escolha JSON (application/json). Insira:
    {
    "parametros": {
        "cliente_id": 1,
        "produto_id": 1
        }
    }
=======
  
   Na aba Body: Selecione raw e escolha JSON (application/json). Insira:
  
      {
      "parametros": {
          "cliente_id": 1,
          "produto_id": 1
          }
      }
>>>>>>> dd6d8a86d588219be932b946c443f6b2a3fd99c3


* GET /api/pedido/{id}: Retorna um pedido específico pelo ID.

* PUT /api/pedido/{id}/editar: Atualiza um pedido existente pelo ID. Campos: cliente_id, produto_id, status é opcional pois o default é 0 (0 = Em Aberto, 1 = Pago e 2 = Cancelado).
  
   Na aba Body: Selecione raw e escolha JSON (application/json). Insira:
  
      {
      "parametros": {
          "cliente_id": 1,
          "produto_id": 1,
          "status": 1
          }
      }

* DELETE /api/pedido/{id}/deletar: Remove fisicamente um pedido pelo ID.

*Parâmetros de Paginação e Filtro*
* GET /api/pedidos?limit={limit}&page={page}&status={status}: Retorna pedidos paginados com limite e página especificados. Você pode opcionalmente filtrar por status e/ou id do cliente e/ou id do produto.
