<link rel="stylesheet" href="{{ asset('css/notification.css') }}">

<dialog id="{{ $id ?? 'notification-dialog' }}" class="notification {{ $type ?? 'info' }}" {{ $attributes }}>
    <div class="notification-container">
        <div class="notification-body">
            <p>{{ $message }}</p>
        </div>
        <div class="notification-header">
            <button type="button" class="close-button" onclick="this.closest('dialog').close()">×</button>
        </div>
    </div>
</dialog>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dialog = document.getElementById('{{ $id ?? "notification-dialog" }}');
        if (dialog && !dialog.open) {
            dialog.show(); // Shows the dialog without modal behavior

            // Override the close method to add animation
            const originalClose = dialog.close;
            dialog.close = function() {
                dialog.classList.add('closing');
                setTimeout(() => {
                    originalClose.call(dialog);
                    dialog.classList.remove('closing');
                }, 300); // Match the animation duration
            };
        }
    });
</script>