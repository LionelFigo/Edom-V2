<?php

it('registers the expected admin dosen routes', function () {
    $router = app('router');

    expect($router->getRoutes()->getByName('admin.dosen.index'))->not->toBeNull();
    expect($router->getRoutes()->getByName('admin.dosen.create'))->not->toBeNull();
    expect($router->getRoutes()->getByName('admin.dosen.store'))->not->toBeNull();
    expect($router->getRoutes()->getByName('admin.dosen.edit'))->not->toBeNull();
    expect($router->getRoutes()->getByName('admin.dosen.update'))->not->toBeNull();
    expect($router->getRoutes()->getByName('admin.dosen.destroy'))->not->toBeNull();
});
