<?php

namespace Tests\Feature;

use Tests\TestCase;

class UrlShortnerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_encode_valid_url()
    {
        $response = $this->postJson('/encode', [
            'url' => 'https://www.thisisalongdomain.com/with/some/parameters?and=here_too'
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['short_url']);
    }

    public function test_encode_invalid_url()
    {
        $response = $this->postJson('/encode', [
            'url' => 'invalid-url'
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['url']);
    }

    public function test_decode_valid_short_url()
    {
        $urlToEncode = 'https://www.thisisalongdomain.com/with/some/parameters?and=here_too';
        // First, we need to encode a URL to get a short URL
        $encodeResponse = $this->postJson('/encode', [
            'url' => $urlToEncode
        ]);

        $shortUrl = $encodeResponse->json('short_url');

        // Now, we can decode the short URL
        $response = $this->postJson('/decode', [
            'short_url' => $shortUrl
        ]);

        $response->assertStatus(200)
                 ->assertJson(['original_url' => $urlToEncode]);
    }

    public function test_decode_invalid_short_url()
    {
        $response = $this->postJson('/decode', [
            'short_url' => 'http://short.est/invalidcode'
        ]);

        $response->assertStatus(404)
                 ->assertJson(['error' => 'URL not found or expired']);
    }
}
