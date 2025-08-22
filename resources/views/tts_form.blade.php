@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Text-to-Speech (TTS)</h2>
    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first('tts') }}
        </div>
    @endif
    <form id="ttsForm">
        <div class="mb-3">
            <label for="texto" class="form-label">Digite o texto:</label>
            <textarea class="form-control" id="texto" name="texto" rows="3" required>{{ old('texto', $texto ?? '') }}</textarea>
        </div>
        <button type="button" class="btn btn-primary" onclick="speakText()">Ouvir</button>
    </form>
    <script>
    function speakText() {
        var texto = document.getElementById('texto').value;
        if (!texto) return;
        var synth = window.speechSynthesis;
        var utter = new SpeechSynthesisUtterance(texto);
        utter.lang = 'pt-BR';
        synth.speak(utter);
    }
    </script>
    @if(!empty($audio))
        <div class="mt-4">
            <audio controls autoplay>
                <source src="{{ $audio }}" type="audio/mpeg">
                Seu navegador não suporta o elemento de áudio.
            </audio>
            <p class="mt-2">Áudio gerado com sucesso!</p>
        </div>
    @endif
</div>
@endsection
