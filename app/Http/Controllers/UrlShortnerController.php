<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache; //cache for better in-memory

class UrlShortnerController extends Controller
{
    private $urlKeyPrefix = 'url:';  // Prefix for cache keys
    private $shortUrlBase = 'http://short.est/'; // Base URL for short URLs
    //private $urlStore = []; // In-memory storage for URLs


    public function encode(Request $request)
    {
        // Validate the request to ensure it has a valid URL
        $request->validate([
            'url' => 'required|url'
        ]);

        // Generate a unique short code
        $shortCode = $this->generateShortCode();

        // Store the original URL in cache with the generated short code
        Cache::put($this->urlKeyPrefix . $shortCode, $request->url, now()->addDays(7)); // Set expiration time as needed

        // Store the original URL with the generated short code in memory
        // $this->urlStore[$shortCode] = $request->url;

         // Log the details of the encoded URL
         Log::info('Encoded URL:', [
            'shortCode' => $shortCode,
            'originalUrl' => $request->url,
        ]);


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

        // Retrieve the original URL from cache using the short code
        $originalUrl = Cache::get($this->urlKeyPrefix . $shortCode);

        // Retrieve the original URL from memory using the short code
        //$originalUrl = $this->urlStore[$shortCode] ?? null;

        if (!$originalUrl) {
            return response()->json([
                'error' => 'URL not found or expired'
            ], 404);
        }

         // Log the original URL being returned
         Log::info('Original URL found:', [
            'originalUrl' => $originalUrl
        ]);

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
