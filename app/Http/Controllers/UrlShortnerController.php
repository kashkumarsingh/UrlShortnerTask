<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UrlShortnerController extends Controller
{
    private $urlKeyPrefix = 'url:';  // Prefix for cache keys
    private $shortUrlBase = 'http://short.est/'; // Base URL for short URLs
    private $urlStore = []; // In-memory storage for URLs

    public function encode(Request $request)
    {
        // Validate the request to ensure it has a valid URL
        $request->validate([
            'url' => 'required|url'
        ]);

        // Generate a unique short code
        $shortCode = $this->generateShortCode();

        // Store the original URL with the generated short code in memory
        $this->urlStore[$shortCode] = $request->url;

        // Return the shortened URL
        return response()->json([
            'short_url' => $this->shortUrlBase . $shortCode
        ]);
    }

    public function decode(Request $request)
    {
        // Validate the request to ensure it has a valid short URL
        $request->validate([
            'short_url' => 'required|url'
        ]);

        // Extract the short code from the short URL
        $shortCode = basename($request->short_url);

        // Retrieve the original URL from memory using the short code
        $originalUrl = $this->urlStore[$shortCode] ?? null;

        if (!$originalUrl) {
            return response()->json([
                'error' => 'URL not found or expired'
            ], 404);
        }

        // Return the original URL
        return response()->json([
            'original_url' => $originalUrl
        ]);
    }

    private function generateShortCode($length = 6)
    {
        return substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, $length);
    }
}
