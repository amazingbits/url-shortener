<?php

describe("generate code", function () {
    it("only letters and numbers", function () {
        $code = generate_short_code();
        $test = preg_match("/^[A-Za-z0-9]+$/", $code);
        expect($test)->toBe(1);
    });

    it("must have between 5 and 10 characters", function () {
        $failed = 0;
        $tests = 100;

        for ($i = 0; $i < $tests; $i++) {
            $code = generate_short_code();
            $test = mb_strlen($code) >= 5 && mb_strlen($code) <= 10;
            if (!$test) {
                $failed++;
            }
        }

        expect($failed)->toBe(0);
    });
});