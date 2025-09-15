<?php

//for testing purposes, feel free to change this amount
$amountOfUsersToCreate = 10;

$users = [];
for ($i = 1; $i <= $amountOfUsersToCreate; $i++) {
    $flowers = [];
    for ($f = 1; $f <= 5; $f++) { // 5 Flowers pro User
        $flowers[] = [
            'name' => "Flower $f",
            'color' => ['Red','Yellow','Blue','White'][array_rand(['Red','Yellow','Blue','White'])],
            'species' => "Species $f"
        ];
    }

    $orders = [];
    for ($o = 1; $o <= 5; $o++) { // 5 Orders pro User
        $items = [];
        for ($it = 1; $it <= 5; $it++) { // 5 Items pro Order
            $items[] = [
                'product' => "Product $it",
                'quantity' => rand(1, 10),
                'price' => rand(10, 100)/1.0
            ];
        }
        $orders[] = [
            'id' => $o,
            'createdAt' => date('c', strtotime("-$o days")),
            'items' => $items
        ];
    }

    $users[] = [
        'id' => $i,
        'firstName' => "First$i",
        'lastName' => "Last$i",
        'email' => "user$i@example.com",
        'createdAt' => date('c', strtotime("-$i days")),
        'flowers' => $flowers,
        'address' => [
            'street' => "Street $i",
            'city' => "City $i",
            'country' => "Country $i",
            'zip' => "100$i"
        ],
        'orders' => $orders
    ];
}

file_put_contents('users_large.json', json_encode($users, JSON_PRETTY_PRINT));
echo "JSON file 'users_large.json' generated.\n";
