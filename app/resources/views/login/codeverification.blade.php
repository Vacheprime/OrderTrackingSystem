<link rel="stylesheet" href="{{ asset('css/login.css') }}">

<x-layout title="Verifying">
  <div id="login-content" class="main-content">
    <h1>2FA</h1>
    <p id="enterVerification">Enter Verification Code</p>
    
    <!-- Container that holds the input and its overlay -->
    <div class="code-input-container">
      <input
        id="dynamicInput"
        type="text"
        maxlength="6"
        class="inputForCode"
        autocomplete="one-time-code"
      />
      <span id="overlayText">-  -  -  -  -  -</span>
    </div>
    <a href="" class="resendCode">Resend code?</a>
    <a href="/newpassword" class="tempVerif">temp verify</a>
    <button class="executeButton" onclick="">Verify</button>
  </div>
</x-layout>

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