// ===== Hamburger menu (JS-driven, menggantikan checkbox hack) =====
function initNavToggle() {
  const toggleBtn = document.getElementById("nav-toggle-btn");
  const nav = document.querySelector("header nav");
  if (!toggleBtn || !nav) return;

  toggleBtn.addEventListener("click", function () {
    nav.classList.toggle("nav-open");
  });
}

// ===== Konfirmasi hapus (Event Delegation untuk data dinamis Fetch API) =====
// Menggunakan event delegation di document agar tombol .btn-hapus yang baru 
// dibuat secara dinamis oleh buku.js / anggota.js tetap bisa mendeteksi klik.
function initHapusConfirm() {
  document.addEventListener("click", function (e) {
    const btn = e.target.closest(".btn-hapus");
    if (!btn) return;

    const row = btn.closest("tr");
    const nama = row ? row.querySelector("td")?.textContent : "data ini";
    const yakin = confirm("Yakin ingin menghapus \"" + nama + "\"?");

    if (yakin && row) {
      const table = row.closest("table");
      row.remove();
      // Perbarui counter setelah baris dinamis dihapus
      if (table) perbaruiCounter(table);
    }
  });
}

// ===== Counter baris tersisa ("Menampilkan X dari Y buku") =====
function perbaruiCounter(table) {
  const counterEl = document.getElementById("counter-baris");
  if (!counterEl) return;
  const semuaBaris = table.querySelectorAll("tbody tr");
  const barisTampil = table.querySelectorAll(
    "tbody tr:not([style*='display: none'])"
  );
  counterEl.textContent =
    "Menampilkan " + barisTampil.length + " dari " + semuaBaris.length + " buku";
}

// ===== Filter/pencarian tabel real-time =====
function initTableFilter() {
  const input = document.getElementById("search-input");
  const table = document.querySelector(".table-responsive table") || document.querySelector("table");
  if (!input || !table) return;

  // Tampilkan counter awal begitu halaman dimuat
  perbaruiCounter(table);

  input.addEventListener("keyup", function () {
    const keyword = input.value.toLowerCase();
    const rows = table.querySelectorAll("tbody tr");
    rows.forEach(function (row) {
      const kolomJudul = row.querySelector("td"); // td pertama = kolom Judul
      const teks = kolomJudul ? kolomJudul.textContent.toLowerCase() : "";
      row.style.display = teks.includes(keyword) ? "" : "none";
    });
    // Perbarui counter setiap kali user mengetik
    perbaruiCounter(table);
  });
}

// ===== Validasi form (client-side) =====
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

// ===== Titik masuk: jalankan semua fungsi setelah DOM siap =====
document.addEventListener("DOMContentLoaded", function () {
  initNavToggle();
  initHapusConfirm();
  initTableFilter();
  initValidasiForm();
});