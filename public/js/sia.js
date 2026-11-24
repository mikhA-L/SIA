/* Mempercantik halaman: label status jadi chip, ikon pada judul dan tombol. */
(function () {
    // 1. Label status menjadi chip berwarna
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

    // 2. Tombol hapus/tutup/tolak berwarna merah
    document.querySelectorAll('.content button, .content input[type="submit"]').forEach(function (b) {
        var teks = (b.textContent || b.value || '').toLowerCase();
        if (/hapus|delete|tutup|tolak/.test(teks)) { b.classList.add('btn-danger-line'); }
    });

    // 3. Ikon pada tombol dan tautan aksi
    var ikonTombol = [
        [/^\+?\s*tambah/, 'bi-plus-lg'], [/^(ubah|edit)/, 'bi-pencil-square'], [/^hapus/, 'bi-trash3'],
        [/^(simpan|perbarui)/, 'bi-check2-circle'], [/^cari/, 'bi-search'], [/^tutup/, 'bi-lock'],
        [/^buka/, 'bi-unlock'], [/^kembali/, 'bi-arrow-left'], [/^daftar/, 'bi-person-plus'],
        [/^masuk/, 'bi-box-arrow-in-right'], [/^keluar/, 'bi-box-arrow-right'],
        [/^(isi nilai|periksa|lihat)/, 'bi-eye'], [/^(setuju|aktifkan)/, 'bi-check-lg'],
        [/^tolak/, 'bi-x-lg'], [/^ajukan/, 'bi-send']
    ];
    document.querySelectorAll('.topbar button, .topbar a:not(.brand), .content a, .content button, .auth-card a, .auth-card button').forEach(function (el) {
        if (el.querySelector('i.bi') || el.closest('.menu') || el.closest('.pagination') || el.closest('.kartu-grid')) { return; }
        var teks = el.textContent.trim().toLowerCase();
        for (var n = 0; n < ikonTombol.length; n++) {
            if (ikonTombol[n][0].test(teks)) {
                var i = document.createElement('i');
                i.className = 'bi ' + ikonTombol[n][1];
                i.setAttribute('aria-hidden', 'true');
                var awal = el.firstChild;
                if (awal && awal.nodeType === 3) { awal.textContent = awal.textContent.replace(/^\s*\+\s*/, ''); }
                el.insertBefore(i, el.firstChild);
                break;
            }
        }
    });

    // 4. Ikon pada judul halaman
    var h1 = document.querySelector('.content h1, .auth-card h1');
    if (h1 && !h1.querySelector('i.bi')) {
        var judul = h1.textContent.toLowerCase();
        var ikonJudul = [
            ['masa input nilai', 'bi-calendar-check-fill'], ['kata sandi', 'bi-key-fill'], ['mata kuliah', 'bi-book-fill'],
            ['mahasiswa', 'bi-mortarboard-fill'], ['dosen', 'bi-person-badge-fill'], ['kelas', 'bi-door-open-fill'],
            ['nilai', 'bi-award-fill'], ['krs', 'bi-journal-check'], ['beranda', 'bi-house-door-fill'],
            ['daftar', 'bi-person-plus-fill'], ['masuk', 'bi-box-arrow-in-right']
        ];
        for (var k = 0; k < ikonJudul.length; k++) {
            if (judul.indexOf(ikonJudul[k][0]) !== -1) {
                var ic = document.createElement('i');
                ic.className = 'bi ' + ikonJudul[k][1];
                ic.setAttribute('aria-hidden', 'true');
                h1.insertBefore(ic, h1.firstChild);
                break;
            }
        }
    }
})();
