/* Mempercantik halaman: label status jadi chip, tombol hapus/tutup berwarna merah. */
(function () {
    var peta = {
        'sudah': 'chip-ok', 'belum': 'chip-muted', 'dibuka': 'chip-ok', 'ditutup': 'chip-no',
        'aktif': 'chip-ok', 'menunggu': 'chip-wait', 'cuti': 'chip-wait', 'non-aktif': 'chip-no',
        'disetujui': 'chip-ok', 'ditolak': 'chip-no', 'diajukan': 'chip-wait', 'draf': 'chip-muted'
    };

    document.querySelectorAll('.content td, .content strong').forEach(function (el) {
        if (el.children.length) { return; }
        var teks = el.textContent.trim();
        var kelas = peta[teks.toLowerCase()];
        if (!kelas) { return; }
        if (el.tagName === 'TD') {
            var span = document.createElement('span');
            span.className = 'chip ' + kelas;
            span.textContent = teks;
            el.textContent = '';
            el.appendChild(span);
        } else {
            el.classList.add('chip', kelas);
        }
    });

    document.querySelectorAll('.content button, .content input[type="submit"]').forEach(function (b) {
        var teks = (b.textContent || b.value || '').toLowerCase();
        if (/hapus|delete|tutup|tolak/.test(teks)) { b.classList.add('btn-danger-line'); }
    });
})();
