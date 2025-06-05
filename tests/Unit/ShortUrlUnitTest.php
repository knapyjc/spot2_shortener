<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\ShortUrl;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;
use ReflectionClass;

class ShortUrlUnitTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_a_new_short_url()
    {
        $url = 'https://example.com';
        $shortUrl = ShortUrl::create([
            'original_url' => $url,
            'short_code' => Str::random(8),
        ]);

        $this->assertDatabaseHas('short_urls', ['original_url' => $url]);
        $this->assertNotNull($shortUrl->short_code);
    }

    /** @test */
    public function it_does_not_duplicate_existing_url()
    {
        $url = 'https://example.com';
        ShortUrl::create([
            'original_url' => $url,
            'short_code' => 'abc12345'
        ]);

        $existing = ShortUrl::where('original_url', $url)->first();

        $this->assertEquals('abc12345', $existing->short_code);
    }

    /** @test */
    public function it_generates_unique_short_code()
    {
        $url1 = ShortUrl::create([
            'original_url' => 'https://example1.com',
            'short_code' => 'unique1',
        ]);

        $url2 = ShortUrl::create([
            'original_url' => 'https://example2.com',
            'short_code' => 'unique2',
        ]);

        $this->assertNotEquals($url1->short_code, $url2->short_code);
    }

    /** @test */
    public function it_throws_exception_if_short_code_is_not_unique()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        ShortUrl::create([
            'original_url' => 'https://example1.com',
            'short_code' => 'duplicate01'
        ]);

        ShortUrl::create([
            'original_url' => 'https://example2.com',
            'short_code' => 'duplicate01'
        ]);
    }
}
