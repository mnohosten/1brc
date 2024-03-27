<?php
declare(strict_types=1);

require 'vendor/autoload.php';

use OpenSwoole\Core\Coroutine\WaitGroup;

co::run(function() {
    $wg = new WaitGroup();
    $chan = new OpenSwoole\Coroutine\Channel(1);

    $results = [];
    go(function () use ($chan) {
        $cid = OpenSwoole\Coroutine::getCid();
        $i = 0;
        while (1) {
            co::sleep(1);
            $chan->push(['rand' => rand(1000, 9999), 'index' => $i]);
            echo "[coroutine $cid] - $i\n";
            $i++;
        }
    });



    go(function () use ($wg, &$results, $chan) {
        $cid = OpenSwoole\Coroutine::getCid();
        while(1) {
            $data = $chan->pop();
            echo "[coroutine $cid]\n";
            var_dump($data);
        }

    });

    $wg->wait(10);
    var_dump($results);
});