// ===== Hamburger Menu Navigasi =====
function initNavToggle() {
  const toggleBtn = document.getElementById("nav-toggle-btn");
  const nav = document.querySelector("header nav");
  if (!toggleBtn || !nav) return;

  toggleBtn.addEventListener("click", function () {
    nav.classList.toggle("nav-open");
  });
}

// ===== Konfirmasi Hapus via Form Submit (Jobsheet 9) =====
function initHapusConfirm() {
  document.addEventListener("submit", function (e) {
    const form = e.target;
    // Cek apakah form yang di-submit adalah form-hapus
    if (!form.classList.contains("form-hapus")) return;

    const row = form.closest("tr");
    const nama = row ? row.querySelector("td")?.textContent : "data ini";
    const yakin = confirm('Yakin ingin menghapus "' + nama.trim() + '"?');

    // Jika user pilih Cancel, batalkan pengiriman form ke hapus.php
    if (!yakin) {
      e.preventDefault();
    }
  });
}

// ===== Validasi Form Tambah/Edit (Client-side) =====
function tampilkanError(input, pesan) {
  hapusError(input);
  const span = document.createElement("span");
  span.className = "error";
  span.textContent = pesan;
  input.insertAdjacentElement("afterend", span);
}

function hapusError(input) {
  const next = input.nextElementSibling;
  if (next && next.classList.contains("error")) {
    next.remove();
  }
}

function initValidasiForm() {
  const form = document.getElementById("form-tambah");
  if (!form) return;

  const aturanValidasi = [
    {
      selector: "[name='judul'], [name='nama']",
      cek: (nilai) => nilai.trim() !== "",
      pesan: "Field ini wajib diisi.",
    },
    {
      selector: "[name='pengarang']",
      cek: (nilai) => nilai.trim() !== "",
      pesan: "Field ini wajib diisi.",
    },
    {
      selector: "[name='tahun']",
      cek: (nilai) => {
        const n = parseInt(nilai, 10);
        return !isNaN(n) && n >= 1900 && n <= 2026;
      },
      pesan: "Tahun harus di antara 1900-2026.",
    },
    {
      selector: "[name='stok']",
      cek: (nilai) => {
        const n = parseInt(nilai, 10);
        return !isNaN(n) && n >= 0;
      },
      pesan: "Stok tidak boleh negatif.",
    },
    {
      selector: "[name='isbn']",
      cek: (nilai) => nilai.trim() === "" || /^[0-9-]+$/.test(nilai),
      pesan: "ISBN hanya boleh berisi angka dan tanda hubung (-).",
    },
  ];

  form.addEventListener("submit", function (e) {
    let valid = true;

    aturanValidasi.forEach(function (aturan) {
      const input = form.querySelector(aturan.selector);
      if (!input) return;

      if (!aturan.cek(input.value)) {
        tampilkanError(input, aturan.pesan);
        valid = false;
      } else {
        hapusError(input);
      }
    });

    if (!valid) {
      e.preventDefault();
    }
  });
}

// ===== Inisialisasi Saat DOM Siap =====
document.addEventListener("DOMContentLoaded", function () {
  initNavToggle();
  initHapusConfirm();
  initValidasiForm();
});