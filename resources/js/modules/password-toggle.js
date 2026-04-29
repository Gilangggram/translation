export function initPasswordToggle() {
    const togglePassBtn = document.getElementById('toggle-password');
    const passInput     = document.getElementById('password');
    const icon          = document.getElementById('eye-icon');

    if (!togglePassBtn || !passInput || !icon) return;

    togglePassBtn.classList.add('hidden');

    // Tampilkan toggle saat ada value
    passInput.addEventListener('input', () => {
        if (passInput.value.length > 0) {
            togglePassBtn.classList.remove('hidden');
        } else {
            togglePassBtn.classList.add('hidden');
            passInput.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    });

    // Toggle show/hide
    togglePassBtn.addEventListener('click', () => {
        if (passInput.type === 'password') {  // ← passInput, bukan input
            passInput.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            passInput.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    });
}