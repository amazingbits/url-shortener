<?php

describe("get expiration date", function () {
    it("should return a date with the specified number of days added", function () {
        $today = new DateTime();
        $daysToAdd = 10;
        $expirationDate = get_expiration_date($daysToAdd);

        $expectedDate = (clone $today)->add(new DateInterval("P{$daysToAdd}D"))->format("Y-m-d H:i:s");

        expect($expirationDate)->toBe($expectedDate);
    });

    it("should return the correct format Y-m-d H:i:s", function () {
        $daysToAdd = 5;
        $expirationDate = get_expiration_date($daysToAdd);

        expect($expirationDate)->toMatch("/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/");
    });

    it("should add 0 days and return today's date", function () {
        $today = new DateTime();
        $expirationDate = get_expiration_date(0);

        $expectedDate = $today->format("Y-m-d H:i:s");
        expect($expirationDate)->toBe($expectedDate);
    });

    it("should add 1 day correctly", function () {
        $today = new DateTime();
        $expirationDate = get_expiration_date(1);

        $expectedDate = (clone $today)->add(new DateInterval("P1D"))->format("Y-m-d H:i:s");

        expect($expirationDate)->toBe($expectedDate);
    });

    it("should return a future date when adding positive days", function () {
        $today = new DateTime();
        $expirationDate = get_expiration_date(10);

        expect(strtotime($expirationDate))->toBeGreaterThan($today->getTimestamp());
    });

    it("should return a past date when adding negative days", function () {
        $today = new DateTime();
        $expirationDate = get_expiration_date(-5);

        expect(strtotime($expirationDate))->toBeLessThan($today->getTimestamp());
    });
});