<?php

// register router prefix
$this->setPrefix('api/v1');

// regsiter get route
$this->get('/loans', 'LoanApi\\Controllers\\LoanController@index');

// regsiter show route
$this->get('/loans/{id}', 'LoanApi\\Controllers\\LoanController@show');

// register post route
$this->post('/loans', 'LoanApi\\Controllers\\LoanController@update');

// register post route
$this->put('/loans', 'LoanApi\\Controllers\\LoanController@store');

// CREATE post
// READ get
// UPDATE put/patch
// DELETE delete