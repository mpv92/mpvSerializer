<?php

/**
 * this is only for testing purposes, if you want to test the serializer locally.
 * Checkout the project and write the following in your console:
 *
 * php -S localhost:8005 -t .
 *
 * Call localhost:8005/generatejson.php in your browser => this will generate a json with the name "users_large.json"
 * this is later used to deserialize and generate the Models, defined in src/Examples
 */

use Mpv92\Serializer\Examples\User;

require_once "vendor/autoload.php";

header('Content-Type: application/json');

$json = file_get_contents("users_large.json");

$serializer = new \Mpv92\Serializer\MpvSerializer();

try {
    $model = $serializer->deserialize($json, User::class);
} catch (Throwable $e) {
    throw new \Mpv92\Serializer\Exceptions\MpvSerializerException();
}

/**
 * output the deserialized models/array
 * var_dump($model[0]);
 * var_dump($model);
 * var_dump($model->flowers[0]->name);
 */