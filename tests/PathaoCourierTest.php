<?php

use Enan\PathaoCourier\Facades\PathaoCourier;
use Enan\PathaoCourier\Services\DataServiceOutput;
use Enan\PathaoCourier\Services\Exceptions\PathaoException;

it('loads package config correctly', function () {
    expect(config('pathao-courier.pathao_base_url'))->toBe('https://api-hermes.pathao.com/')
        ->and(config('pathao-courier.pathao_db_table_name'))->toBe('pathao-courier');
});

it('resolves PathaoCourier facade', function () {
    $facadeRoot = PathaoCourier::getFacadeRoot();
    expect($facadeRoot)->toBeInstanceOf(\Enan\PathaoCourier\PathaoCourier::class);
});

it('can create and render PathaoException', function () {
    $exception = new PathaoException('Validation Error', 417, ['phone' => ['Invalid phone number']]);

    $rendered = $exception->render();
    expect($rendered)->toBeArray()
        ->and($rendered['error'])->toBeTrue()
        ->and($rendered['code'])->toBe(417)
        ->and($rendered['message'])->toBe('Validation Error')
        ->and($rendered['errors'])->toHaveKey('phone');
});

it('formats DataServiceOutput correctly', function () {
    $output = new DataServiceOutput(['test' => 123], 'Success message', true, 200);

    expect($output->getData())->toBe(['test' => 123])
        ->and($output->getMessage())->toBe('Success message')
        ->and($output->isSuccess())->toBeTrue()
        ->and($output->getStatusCode())->toBe(200);
});
