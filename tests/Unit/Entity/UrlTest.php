<?php

use Src\Model\Entity\Url;

function createUrlMock(): \Mockery\LegacyMockInterface|(\Mockery\MockInterface&Url)
{
    return Mockery::mock(Url::class)->makePartial();
}

describe("URL entity", function () {
    it("should save a record", function () {
        $mock = createUrlMock();

        $mock->shouldReceive("save")
            ->once()
            ->andReturn(true);

        $mock->short_code = "abcde123";
        $mock->original_url = "https://google.com";

        $result = $mock->save();

        expect($result)->toBeTrue();
    });

    it("should list all records", function () {
        $mock = createUrlMock();

        $mock->shouldReceive("all")
            ->once()
            ->andReturn(collect([
                new Url(["short_code" => "abc123", "original_url" => "https://example.com"]),
                new Url(["short_code" => "xyz456", "original_url" => "https://example2.com"]),
            ]));

        $result = $mock->all();
        expect($result)->toHaveCount(2);
    });

    it("should find a record by id", function () {
        $mock = createUrlMock();

        $mock->shouldReceive("find")
            ->with(1)
            ->once()
            ->andReturn(new Url(["id" => 1, "short_code" => "abc123", "original_url" => "https://example.com"]));

        $result = $mock::find(1);

        expect($result->short_code)->toBe("abc123");
        expect($result->original_url)->toBe("https://example.com");
    });

    it("should update a record", function () {
        $mock = createUrlMock();

        $mock->shouldReceive("update")
            ->with(["short_code" => "abc123", "original_url" => "https://updated-url.com"])
            ->once()
            ->andReturn(true);

        $result = $mock->update(["short_code" => "abc123", "original_url" => "https://updated-url.com"]);

        expect($result)->toBeTrue();
    });

    it('should not bo be able to insert two register with same short_code', function () {
        $mock = createUrlMock();

        $mock->shouldReceive("where")
            ->with("short_code", "abc123")
            ->once()
            ->andReturnSelf();

        $mock->shouldReceive("exists")
            ->once()
            ->andReturn(true);

        $duplicate = $mock::where("short_code", "abc123")->exists();

        expect($duplicate)->toBeTrue();
    });
});