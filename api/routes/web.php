<?php

//main rout for returning invoices based on the front filters
$router->post('/', 'InvoicesController@index');

//returns a product list based by client id
$router->post('/products_by_client', 'InvoicesController@getProductsByClient');

//returns the client list
$router->post('/clients', 'InvoicesController@getClients');