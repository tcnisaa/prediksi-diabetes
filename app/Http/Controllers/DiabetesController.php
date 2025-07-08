<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DiabetesController extends Controller
{
    public function index()
    {
        return view('diabetes-form');
    }

    public function predict(Request $request)
    {
        $request->validate([
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'umur' => 'required|numeric|min:1|max:120',
            'tekanan_darah' => 'required|in:Normal,Tinggi',
            'riwayat_penyakit_jantung' => 'required|in:Ya,Tidak',
            'riwayat_merokok' => 'required',
            'bmi' => 'required|numeric|min:10|max:60',
            'gula_darah' => 'required|numeric|min:50|max:500',
        ]);

        // Siapkan data untuk API
        $apiData = [
            'gender' => $request->jenis_kelamin,
            'age' => (int) $request->umur,
            'hypertension' => $request->tekanan_darah,
            'heart_disease' => $request->riwayat_penyakit_jantung,
            'smoking_history' => $request->riwayat_merokok,
            'bmi' => (float) $request->bmi,
            'blood_glucose_level' => (float) $request->gula_darah,
        ];

        try {
            // Kirim ke Hugging Face API
           $response = Http::withOptions(['verify' => false]) // Tambahkan ini
            ->timeout(30)
            ->post('https://tcnisaa-prediksi-dm-adaboost.hf.space/predict', $apiData);


            if ($response->successful()) {
                $prediction = $response->json();

                // Logging untuk debug
                Log::info('Data ke API:', $apiData);
                Log::info('Hasil prediksi:', $prediction);

                $riskClass = $this->getRiskClass($prediction['hasil']);

                return view('diabetes-form', [
                    'result' => $prediction,
                    'riskClass' => $riskClass,
                    'oldData' => $request->all()
                ]);
            } else {
                Log::error('API Error: ' . $response->body());
                return back()
                    ->withInput()
                    ->with('error', 'Terjadi kesalahan saat menghubungi layanan prediksi. Silakan coba lagi.');
            }
        } catch (\Exception $e) {
            Log::error('Prediction Error: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'Tidak dapat terhubung ke layanan prediksi. Pastikan koneksi internet Anda stabil.');
        }
    }

    private function getRiskClass($hasil)
    {
        if (strpos($hasil, 'Tidak Berisiko') !== false) {
            return 'low';
        } elseif (strpos($hasil, 'Sedang') !== false) {
            return 'medium';
        } else {
            return 'high';
        }
    }
}
