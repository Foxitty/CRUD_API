Sistema de Pedidos com CRUD (CodeIgniter 4)


Este projeto é um exemplo de um sistema de pedidos implementado utilizando o framework CodeIgniter 4. Ele inclui operações básicas de CRUD (Create, Read, Update, Delete) para pedidos, clientes e produtos, usando um banco de dados MySQL.

Pré-requisitos
Antes de começar, certifique-se de ter instalado em seu ambiente de desenvolvimento:

PHP 7.3 ou superior
MySQL
Composer
Instalação
Clonar o repositório:

git clone git@github.com:Foxitty/CRUD_API.git

Configurar o ambiente:

Copie o arquivo .env.example para .env e configure-o com suas credenciais de banco de dados:

cp .env.example .env
Configure as variáveis de ambiente necessárias no arquivo .env (como banco de dados, URL base, etc).

Executar as migrações do banco de dados:

Execute as migrações para criar as tabelas necessárias no banco de dados:

php spark migrate
Isso criará as tabelas pedidos, clientes, produtos e suas respectivas estruturas no banco de dados configurado.

Iniciar o servidor de desenvolvimento:

Use o comando abaixo para iniciar o servidor de desenvolvimento do CodeIgniter:

php spark serve

Uso
Endpoints Disponíveis
A API possui os seguintes endpoints principais:

GET /clientes: Retorna todos os clientes cadastrados.

POST /cliente/novo: Cria um novo cliente.

GET /cliente/{id}: Retorna um cliente específico pelo ID.

PUT /cliente/{id}/editar: Atualiza um cliente existente pelo ID.

PUT /cliente/{id}/deletar: Faz a remoção lógica de um cliente pelo ID.

Parâmetros de Paginação e Filtro
GET /clientes?limit={limit}&page={page}&nome_razao_social={nome_razao_social}: Retorna pedidos paginados com limite e página especificados. Você pode opcionalmente filtrar por cpf_cnpj ou nome_razao_social.

GET /produtos: Retorna todos os produtos cadastrados.

POST /produto/novo: Cria um novo produto.

GET /produto/{id}: Retorna um produto específico pelo ID.

PUT /produto/{id}/editar: Atualiza um produto existente pelo ID.

PUT /produto/{id}/deletar: Remove um produto pelo ID.

Parâmetros de Paginação e Filtro
GET /produtos?limit={limit}&page={page}&nome={nome}: Retorna pedidos paginados com limite e página especificados. Você pode opcionalmente filtrar por nome ou preco.

GET /pedidos: Retorna todos os pedidos cadastrados.

POST /pedido/novo: Cria um novo pedido.

GET /pedido/{id}: Retorna um pedido específico pelo ID.

PUT /pedido/{id}/editar: Atualiza um pedido existente pelo ID.

DELETE /pedido/{id}/deletar: Remove fisicamente um pedido pelo ID.

Parâmetros de Paginação e Filtro
GET /pedidos?limit={limit}&page={page}&status={status}: Retorna pedidos paginados com limite e página especificados. Você pode opcionalmente filtrar por status, id do cliente ou id do produto.
