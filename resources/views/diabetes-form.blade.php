<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prediksi Risiko Diabetes Melitus</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 600px;
            width: 100%;
            position: relative;
            overflow: hidden;
        }

        .container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            font-size: 28px;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #555;
            font-size: 14px;
        }

        input[type="number"],
        select {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e1e5e9;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        input[type="number"]:focus,
        select:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 20px;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        .result {
            margin-top: 30px;
            padding: 20px;
            border-radius: 15px;
            text-align: center;
            font-size: 18px;
            font-weight: 600;
            animation: fadeIn 0.5s ease-in;
        }

        .result.low {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }

        .result.medium {
            background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
            color: #8b4513;
        }

        .result.high {
            background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);
            color: #d63384;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .calculator-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 30px;
        }

        .calculator-section h3 {
            margin-bottom: 15px;
            color: #495057;
            font-size: 18px;
        }

        .bmi-calculator {
            display: grid;
            grid-template-columns: 1fr 1fr auto;
            gap: 10px;
            align-items: end;
        }

        .bmi-result {
            margin-top: 10px;
            padding: 10px;
            background: white;
            border-radius: 8px;
            font-weight: 500;
            text-align: center;
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
            
            .bmi-calculator {
                grid-template-columns: 1fr;
            }
            
            .container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Prediksi Risiko Diabetes Melitus</h1>
        
        <div class="calculator-section">
            <h3>Kalkulator BMI</h3>
            <div class="bmi-calculator">
                <div>
                    <label>Tinggi Badan (cm)</label>
                    <input type="number" id="height" placeholder="Contoh: 170">
                </div>
                <div>
                    <label>Berat Badan (kg)</label>
                    <input type="number" id="weight" placeholder="Contoh: 65">
                </div>
                <button type="button" class="btn" style="width: auto; padding: 10px 20px; margin-top: 0;" onclick="calculateBMI()">Hitung</button>
            </div>
            <div class="bmi-result" id="bmi-result" style="display: none;">
                BMI Anda: <span id="bmi-value"></span>
            </div>
        </div>

<form method="POST" action="/predict">
    @csrf

    <div class="form-row">
        <div class="form-group">
            <label for="jenis_kelamin">Jenis Kelamin</label>
            <select name="jenis_kelamin" id="jenis_kelamin" required>
                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>

        <div class="form-group">
            <label for="umur">Umur</label>
            <input type="number" name="umur" id="umur" value="{{ old('umur') }}" placeholder="Masukkan umur" required>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label for="tekanan_darah">Tekanan Darah</label>
            <select name="tekanan_darah" id="tekanan_darah" required>
                <option value="Normal" {{ old('tekanan_darah') == 'Normal' ? 'selected' : '' }}>Normal</option>
                <option value="Tinggi" {{ old('tekanan_darah') == 'Tinggi' ? 'selected' : '' }}>Tinggi</option>
            </select>
        </div>

        <div class="form-group">
            <label for="riwayat_penyakit_jantung">Riwayat Penyakit Jantung</label>
            <select name="riwayat_penyakit_jantung" id="riwayat_penyakit_jantung" required>
                <option value="Ya" {{ old('riwayat_penyakit_jantung') == 'Ya' ? 'selected' : '' }}>Ya</option>
                <option value="Tidak" {{ old('riwayat_penyakit_jantung') == 'Tidak' ? 'selected' : '' }}>Tidak</option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="riwayat_merokok">Riwayat Merokok</label>
        <select name="riwayat_merokok" id="riwayat_merokok" required>
            <option value="tidak pernah merokok" {{ old('riwayat_merokok') == 'tidak pernah merokok' ? 'selected' : '' }}>tidak pernah merokok</option>
            <option value="mantan perokok" {{ old('riwayat_merokok') == 'mantan perokok' ? 'selected' : '' }}>mantan perokok</option>
            <option value="perokok aktif" {{ old('riwayat_merokok') == 'perokok aktif' ? 'selected' : '' }}>perokok aktif</option>
        </select>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label for="bmi">BMI</label>
            <input type="number" name="bmi" id="bmi" step="0.1" value="{{ old('bmi') }}" placeholder="Masukkan BMI" required>
        </div>

        <div class="form-group">
            <label for="gula_darah">Gula Darah Sewaktu</label>
            <input type="number" name="gula_darah" id="gula_darah" step="0.1" value="{{ old('gula_darah') }}" placeholder="mg/dL" required>
        </div>
    </div>

    <button type="submit" class="btn">Periksa Risiko</button>
</form>


        @if(isset($result))
        <div class="result {{ $riskClass }}" style="display: block;">
            <strong>Hasil Prediksi:</strong><br>
            {{ $result['hasil'] }}<br>
            <small>Probabilitas: {{ $result['probabilitas'] }}</small>
        </div>
        @endif

        @if(session('error'))
        <div class="error">{{ session('error') }}</div>
        @endif
    </div>

    <script>
        function calculateBMI() {
            const height = parseFloat(document.getElementById('height').value);
            const weight = parseFloat(document.getElementById('weight').value);
            
            if (height && weight) {
                const bmi = (weight / ((height / 100) ** 2)).toFixed(1);
                document.getElementById('bmi').value = bmi;
                document.getElementById('bmi-value').textContent = bmi;
                document.getElementById('bmi-result').style.display = 'block';
            } else {
                alert('Mohon masukkan tinggi dan berat badan yang valid');
            }
        }

    </script>
</body>
</html>