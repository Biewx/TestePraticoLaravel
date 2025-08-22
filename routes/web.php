
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TextToSpeechController;

Route::get('/', function () {
    return redirect()->route('tts.form');
});

// Rota de teste
Route::get('/teste', function () {
    return 'Rota de teste funcionando!';
});

// Formulário para digitar o texto
Route::get('/tts', [TextToSpeechController::class, 'index'])->name('tts.form');

// Endpoint para reproduzir o áudio
Route::post('/tts/speak', [TextToSpeechController::class, 'speak'])->name('tts.speak');
