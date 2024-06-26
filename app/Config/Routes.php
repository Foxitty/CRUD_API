<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->post('api/login', 'AuthController::login');

$routes->group('api', ['filter' => 'jwtauth'], function ($routes) {

    // Rotas de cliente
    $routes->get('clientes', 'ClienteController::list');
    $routes->post('cliente/novo', 'ClienteController::create');
    $routes->get('cliente/(:any)', 'ClienteController::read/$1');
    $routes->put('cliente/(:any)/editar', 'ClienteController::update/$1');
    $routes->put('cliente/(:any)/deletar', 'ClienteController::delete/$1');

    // Rotas de produto
    $routes->get('produtos', 'ProdutoController::list');
    $routes->post('produto/novo', 'ProdutoController::create');
    $routes->get('produto/(:any)', 'ProdutoController::read/$1');
    $routes->put('produto/(:any)/editar', 'ProdutoController::update/$1');
    $routes->put('produto/(:any)/deletar', 'ProdutoController::delete/$1');

    // Rotas de pedido
    $routes->get('pedidos', 'PedidoController::list');
    $routes->post('pedido/novo', 'PedidoController::create');
    $routes->get('pedido/(:any)', 'PedidoController::read/$1');
    $routes->put('pedido/(:any)/editar', 'PedidoController::update/$1');
    $routes->delete('pedido/(:any)/deletar', 'PedidoController::delete/$1');
});