<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShortUrl;
use Illuminate\Support\Str;

class ShortUrlController
{
    public function form()
    {
        return view('shortener');
    }

    public function list()
    {
        $urls = ShortUrl::latest()->get();
        return view('urls_list', compact('urls'));
    }

    public function destroy($id)
    {
        ShortUrl::findOrFail($id)->delete();
        return redirect()->route('shortener.list')->with('success', 'URL successfully removed.');
    }

    public function shorten(Request $request)
    {
        $this->validateUrl($request);
        $shortUrl = $this->createOrGetShortUrl($request->url);
        return redirect()->route('shortener.list')->with('success', 'URL shortened successfully.');
    }

    public function redirect($code)
    {
        $shortUrl = ShortUrl::where('short_code', $code)->firstOrFail();
        $shortUrl->increment('clicks');

        return view('redirect_wait', [
            'original_url' => $shortUrl->original_url,
            'short_url' => $code
        ]);
    }

    private function validateUrl(Request $request)
    {
        $request->validate([
            'url' => 'required|url|max:2048',
        ]);
    }

    private function createOrGetShortUrl(string $url, int $length = 8): ShortUrl
    {
        $existing = ShortUrl::where('original_url', $url)->first();

        if ($existing) {
            return $existing;
        }

        do {
            $code = $this->generateSecureShortCode($length);
        } while (ShortUrl::where('short_code', $code)->exists());

        return ShortUrl::create([
            'original_url' => $url,
            'short_code' => $code,
        ]);
    }

    private function generateSecureShortCode(int $length): string
    {
        $bytes = random_bytes($length);
        $base62 = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $result = '';

        foreach (str_split($bytes) as $byte) {
            $result .= $base62[ord($byte) % 62];
        }

        return $result;
    }

}
