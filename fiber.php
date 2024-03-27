<?php
$fibers = [];

$fibers[] = new Fiber(function () {
    for ($i = 0; $i < 5; $i++) {
        echo $i;
        Fiber::suspend();
    }

    return 'numbers';
});

$fibers[] = new Fiber(function () {
    Fiber::suspend();
    foreach (range('a', 'f') as $i) {
        echo $i;
        Fiber::suspend();
    }

    return 'alphabet';
});


$output = array_fill_keys(array_keys($fibers), null);
while ($fibers) {
    foreach ($fibers as $key => $fiber) {
        try {
            if (!$fiber->isStarted()) {
                $fiber->start();
            } elseif ($fiber->isSuspended()) {
                $fiber->resume();
            }
            if ($fiber->isTerminated()) {
                $output[$key] = $fiber->getReturn();
                unset($fibers[$key]);
            }
        } catch (Throwable $e) {
            unset($fibers[$key]);
            // log($e) and continue, set to output, or throw
            $output[$key] = $e;
        }
    }
}
echo "\n";
print_r($output);