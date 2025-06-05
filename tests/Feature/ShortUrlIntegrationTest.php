<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\ShortUrl;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShortUrlIntegrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_shows_the_form()
    {
        $response = $this->get('/shorten');
        $response->assertStatus(200);
        $response->assertViewIs('shortener');
    }

    /** @test */
    public function it_shortens_a_url_and_redirects_to_list()
    {
        $response = $this->post('/shorten', ['url' => 'https://example.com']);
        $response->assertRedirect(route('shortener.list'));

        $this->assertDatabaseHas('short_urls', ['original_url' => 'https://example.com']);
    }

    /** @test */
    public function it_redirects_from_short_url()
    {
        $url = ShortUrl::create([
            'original_url' => 'https://laravel.com',
            'short_code' => 'testcode'
        ]);

        $response = $this->get('/testcode');
        $response->assertStatus(200);
        $response->assertViewIs('redirect_wait');
        $response->assertViewHas('original_url', 'https://laravel.com');
    }

    /** @test */
    public function it_deletes_a_url()
    {
        $url = ShortUrl::create([
            'original_url' => 'https://example.com',
            'short_code' => 'delete01'
        ]);

        $response = $this->delete("/urls/{$url->id}");
        $response->assertRedirect(route('shortener.list'));
        $this->assertDatabaseMissing('short_urls', ['id' => $url->id]);
    }

    /** @test */
    public function it_validates_url_on_shorten()
    {
        $response = $this->post('/shorten', ['url' => 'not-a-valid-url']);
        $response->assertSessionHasErrors('url');
    }

    /** @test */
    public function it_prevents_duplicate_shortening()
    {
        $url = ShortUrl::create([
            'original_url' => 'https://duplicate.com',
            'short_code' => 'dupli01'
        ]);

        $this->post('/shorten', ['url' => 'https://duplicate.com']);
        $this->assertEquals(1, ShortUrl::where('original_url', 'https://duplicate.com')->count());
    }

    /** @test */
    public function it_increments_clicks_on_redirect()
    {
        $shortUrl = ShortUrl::create([
            'original_url' => 'https://clicktest.com',
            'short_code' => 'click01',
            'clicks' => 0
        ]);

        $this->get('/click01');
        $this->assertEquals(1, ShortUrl::find($shortUrl->id)->clicks);
    }

    /** @test */
    public function it_returns_404_for_nonexistent_code()
    {
        $response = $this->get('/notfound123');
        $response->assertStatus(404);
    }
}
