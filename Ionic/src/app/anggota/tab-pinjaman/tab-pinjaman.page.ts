import { Component, AfterViewInit } from '@angular/core';
import { Router } from '@angular/router';
import { HttpClient } from '@angular/common/http';

@Component({
  selector: 'app-tab-pinjaman',
  templateUrl: './tab-pinjaman.page.html',
  styleUrls: ['./tab-pinjaman.page.scss'],
  standalone: false
})
export class TabPinjamanPage implements AfterViewInit {

  minValue: number = 200000;
  maxValue: number = 5000000;
  stepValue: number = 50000;
  rangeValue: number = this.minValue;
  biayaBunga: number = 0;
  subtotal: number = 0;
  biayaPerhari: number = 0;
  tenorDipilih: number | null = null;

  tenorOptions = [
    { label: '3 Bulan/90 Hari', days: 90, nominal: 0 },
    { label: '6 Bulan/180 Hari', days: 180, nominal: 0 }
  ];

  constructor(private router: Router, private http: HttpClient) {
    this.updateValue();
  }

  // 🔍 DOM Observer untuk atribut perubahan
  ngAfterViewInit() {
    const outletEl = document.querySelector('ion-router-outlet');
    if (outletEl) {
      const observer = new MutationObserver(mutations => {
        mutations.forEach(m => {
          if (m.attributeName === 'aria-hidden') {
            console.log('[MutationObserver] Perubahan aria-hidden:', outletEl.getAttribute('aria-hidden'));
          }
        });
      });

      observer.observe(outletEl, { attributes: true });
    }
  }

  ionViewDidEnter() {
    const outletEl = document.querySelector('ion-router-outlet');
    if (outletEl) {
      console.log('[ionViewDidEnter] Masuk halaman Pinjaman');
      console.log('[ionViewDidEnter] aria-hidden:', outletEl.getAttribute('aria-hidden'));
    }
  }

  ionViewWillLeave() {
    const outletEl = document.querySelector('ion-router-outlet');
    if (outletEl) {
      console.log('[ionViewWillLeave] Keluar halaman Pinjaman');
      console.log('[ionViewWillLeave] aria-hidden:', outletEl.getAttribute('aria-hidden'));
    }
  }

  formatCurrency(value: number): string {
    return new Intl.NumberFormat('id-ID', {
      style: 'currency',
      currency: 'IDR',
      minimumFractionDigits: 0
    }).format(value);
  }

  updateValue() {
    console.log(this.rangeValue);
    this.biayaBunga = this.rangeValue * 0.05;
    this.subtotal = this.rangeValue + this.biayaBunga;
    this.updateTenorNominal();
  }

  updateTenorNominal() {
    this.tenorOptions.forEach(option => {
      option.nominal = this.subtotal / option.days;
    });
  }

  pilihTenor(index: number) {
    this.tenorDipilih = index;
    this.biayaPerhari = this.tenorOptions[index].nominal;
  }

  getCicilanLabel(): string {
    if (this.tenorDipilih === null) return 'Pilih Tenor';
    const selectedTenor = this.tenorOptions[this.tenorDipilih];
    return selectedTenor.label.split('/')[0];
  }

  goToHasilPinjaman() {
    if (this.tenorDipilih === null) return;

    const transferData = {
      danaDiajukan: this.rangeValue,
      subtotal: this.subtotal,
      biayaBunga: this.biayaBunga,
      biayaPerhari: this.biayaPerhari,
      tenor: this.tenorOptions[this.tenorDipilih].label,
      tenorHari: this.tenorOptions[this.tenorDipilih].days,
      tanggal: new Date().toLocaleString('id-ID', {
        weekday: 'long',
        day: 'numeric',
        month: 'long',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
      })
    };

    this.router.navigate(['/hasil-pinjaman'], { state: transferData });
  }

  submitPinjaman() {
    const token = localStorage.getItem('auth_token');
    if (!token) {
      console.error('Token tidak ditemukan. Harap login kembali.');
      return;
    }

    if (this.tenorDipilih === null) {
      alert('Mohon pilih tenor terlebih dahulu.');
      return;
    }

    const tenorHari = this.tenorOptions[this.tenorDipilih].days;
    const lama_angsuran = Math.round(tenorHari / 30); // Misal 90 → 3 bulan

    const data = {
      nominal: this.rangeValue,
      lama_angsuran: lama_angsuran
    };

    console.log('Data yang dikirim ke server:', data);

    this.http.post('http://localhost:8000/api/anggota/pinjaman/request', data, {
      headers: {
        Authorization: `Bearer ${token}`
      },
      observe: 'response'
    }).subscribe({
      next: (response) => {
        if (response.status === 201 || response.status === 200) {
          alert('Pengajuan pinjaman berhasil.');
          const user = JSON.parse(localStorage.getItem('user') || '{}');
          const riwayatBaru = {
            nama: user.nama,
            nominal: this.rangeValue,
            tenor: this.tenorOptions[this.tenorDipilih!]?.label || 'Tidak dipilih',
            tanggal: new Date().toISOString(),
            bunga: this.biayaBunga,
            metode: 'Pinjaman',
            status: 'Pending',
            source: 'pinjaman'
          };

          const existing = JSON.parse(localStorage.getItem('riwayat_transaksi_anggota') || '[]');
          existing.unshift(riwayatBaru);
          localStorage.setItem('riwayat_transaksi_anggota', JSON.stringify(existing));

          // 🔁 Navigasi ke halaman beranda atau hasil
          this.router.navigate(['/anggota/beranda']);
          
        } else {
          alert('Respon tidak dikenali. Silakan coba lagi.');
          console.error('Unexpected status:', response.status);
        }
      },
      error: (err) => {
        alert('Gagal mengajukan pinjaman. Silakan coba lagi.');
        console.error('Status Error:', err.status);
        console.error('Pesan Error:', err.message);
        console.error('Detail Error Response:', err.error);
      }
    });
  }
}
