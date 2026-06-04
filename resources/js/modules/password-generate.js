export function initGeneratePassword() {
    const generatePassBtn = document.getElementById('btn-generate-password');
    const passInput = document.getElementById('password');

    if (!generatePassBtn || !passInput) return;

    function generatePassword() {
        const prefix = 'DePallet-';
        const length = 8;
        const charset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        let randomChar = '';
        const randomValues = new Uint32Array(length);
        
        window.crypto.getRandomValues(randomValues);

        for (let i = 0; i < length; i++) {
            randomChar += charset[randomValues[i] % charset.length];
        }

        return prefix + randomChar;
    }

    generatePassBtn.addEventListener('click', function () {
        const newPassword = generatePassword();
        passInput.value = newPassword;
        passInput.dispatchEvent(new Event('input', { bubbles: true }));
    });
}