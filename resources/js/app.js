import Alpine from 'alpinejs';

// Global Toast Dispatcher
window.showToast = function (message, type = 'success') {
    window.dispatchEvent(new CustomEvent('notify', {
        detail: { message, type }
    }));
};

// Clipboard helper with automatic toast
window.copyToClipboard = function (text, message = 'Berhasil disalin ke clipboard!') {
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(text).then(() => {
            window.showToast(message, 'success');
        }).catch(() => {
            fallbackCopy(text, message);
        });
    } else {
        fallbackCopy(text, message);
    }
};

function fallbackCopy(text, message) {
    const textArea = document.createElement('textarea');
    textArea.value = text;
    textArea.style.position = 'fixed';
    textArea.style.opacity = '0';
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    try {
        document.execCommand('copy');
        window.showToast(message, 'success');
    } catch (err) {
        window.showToast('Gagal menyalin teks.', 'error');
    }
    document.body.removeChild(textArea);
}

window.Alpine = Alpine;
Alpine.start();
