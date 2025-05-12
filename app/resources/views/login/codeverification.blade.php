<link rel="stylesheet" href="{{ asset('css/login.css') }}">

<x-login-layout title="Verifying">
    <div id="code-verification-content" class="main-content">
        <h1 id="code-header">2FA</h1>
        <!-- Container that holds the input and its overlay -->
        <form id="code-input-form" method="POST" action="/code2fa">
            <div id="code-input-container">
                <p id="enter-verification-p">Enter Verification Code</p>
                @csrf
                <div id="code-input-div">
                    <div class="code-input-container">
                        <input
                            id="dynamicInput"
                            name="verification-code"
                            type="text"
                            maxlength="6"
                            class="inputForCode"
                            autocomplete="one-time-code"
                        />
                        <span id="overlayText">-  -  -  -  -  -</span>
                    </div>
                    @error('verification-code')
                    <p class="error-input">{{$message}}</p>
                    @enderror
                    <a href="" class="resendCode">Resend code?</a>
                </div>
            </div>
            <button class="regular-button">Verify</button>
        </form>
    </div>
</x-login-layout>

<script>
    const totalDigits = 6;
    const dynamicInput = document.getElementById('dynamicInput');
    const overlayText = document.getElementById('overlayText');

    function updateOverlay() {
        const value = dynamicInput.value;
        let display = "";
        for (let i = 0; i < totalDigits; i++) {
            display += (i < value.length ? value[i] : "-");
            if (i < totalDigits - 1) {
                display += "  ";
            }
        }
        overlayText.textContent = display;
    }

    dynamicInput.addEventListener('input', updateOverlay);
</script>
