<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TextToSpeechController extends Controller
{
    public function index()
    {
        return view('tts_form');
    }

    public function speak(Request $request)
    {
        $request->validate([
            'texto' => 'required|string|max:500',
        ]);

        $texto = $request->input('texto');
        $apiKey = 'sk_ddf1f4f4ea34be79bf3f96a0698642160ab7d33a89c7e0cb';
        $voiceId = 'EXAVITQu4vr4xnSDxMaL'; // Voz padrão ElevenLabs
        $url = 'https://api.elevenlabs.io/v1/text-to-speech/' . $voiceId;

        $response = Http::withHeaders([
            'xi-api-key' => $apiKey,
            'Accept' => 'audio/mpeg',
            'Content-Type' => 'application/json',
        ])->post($url, [
            'text' => $texto,
            'model_id' => 'eleven_monolingual_v1',
            'voice_settings' => [
                'stability' => 0.5,
                'similarity_boost' => 0.5
            ]
        ]);

        if ($response->successful() && $response->header('content-type') === 'audio/mpeg') {
            $audioData = $response->body();
            $fileName = 'tts_' . time() . '.mp3';
            $filePath = storage_path('app/public/' . $fileName);
            file_put_contents($filePath, $audioData);

            $audioUrl = asset('storage/' . $fileName);
            return view('tts_form', ['audio' => $audioUrl, 'texto' => $texto]);
        } else {
            $errorMsg = 'Erro ao gerar áudio.';
            if ($response->json('detail')) {
                $errorMsg .= ' ' . $response->json('detail');
            }
            return back()->withErrors(['tts' => $errorMsg]);
        }
    }
}
