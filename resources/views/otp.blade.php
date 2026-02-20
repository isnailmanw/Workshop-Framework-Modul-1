<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Verifikasi OTP</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="bg-white p-8 rounded-2xl shadow-lg w-96 text-center">
        <h2 class="text-2xl font-bold mb-2">Verifikasi OTP</h2>
        <p class="text-gray-500 mb-6">Masukkan kode OTP yang dikirim ke email</p>

        <form action="/verify-otp" method="POST">
            @csrf

            <!-- INPUT OTP -->
            <div class="flex justify-between mb-6">
                <input type="text" maxlength="1" class="otp-input w-12 h-12 text-center border rounded-lg text-xl">
                <input type="text" maxlength="1" class="otp-input w-12 h-12 text-center border rounded-lg text-xl">
                <input type="text" maxlength="1" class="otp-input w-12 h-12 text-center border rounded-lg text-xl">
                <input type="text" maxlength="1" class="otp-input w-12 h-12 text-center border rounded-lg text-xl">
                <input type="text" maxlength="1" class="otp-input w-12 h-12 text-center border rounded-lg text-xl">
                <input type="text" maxlength="1" class="otp-input w-12 h-12 text-center border rounded-lg text-xl">
            </div>

            <!-- HIDDEN INPUT -->
            <input type="hidden" name="otp" id="otp">

            <!-- ERROR -->
            @if(session('error'))
                <p class="text-red-500 mb-3">{{ session('error') }}</p>
            @endif

            <button class="bg-blue-500 text-white w-full py-2 rounded-lg hover:bg-blue-600">
                Verifikasi
            </button>
        </form>
    </div>

    <script>
        const inputs = document.querySelectorAll('.otp-input');
        const otpField = document.getElementById('otp');

        inputs.forEach((input, index) => {
            input.addEventListener('input', () => {
                if (input.value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
                updateOTP();
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === "Backspace" && !input.value && index > 0) {
                    inputs[index - 1].focus();
                }
            });
        });

        function updateOTP() {
            let otp = '';
            inputs.forEach(input => {
                otp += input.value;
            });
            otpField.value = otp;
        }
    </script>

</body>

</html>