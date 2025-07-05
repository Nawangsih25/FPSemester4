import { Component, OnInit } from '@angular/core';
import { CurrencyPipe } from '@angular/common';
import { Router } from '@angular/router';
import { HttpClient, HttpHeaders } from '@angular/common/http';

@Component({
  selector: 'app-bayar-angsuran',
  templateUrl: './bayar-angsuran.page.html',
  styleUrls: ['./bayar-angsuran.page.scss'],
  standalone: false,
  providers: [CurrencyPipe],
})
export class BayarAngsuranPage implements OnInit {
  pinjamanList: any[] = [];
  selectedPinjaman: any = null; //baru

  nominalBayar: number | null = null;
  formattedNominal: string = '';
  nominalCepat = [10000, 20000, 50000];

  metodePembayaran: string = 'cash'; // default
  catatan: string = '';
  metodeTransfer: string = '';

  constructor(
    private currencyPipe: CurrencyPipe,
    private router: Router,
    private http: HttpClient
  ) {}

  ngOnInit() {
    const navigation = this.router.getCurrentNavigation();
    const state = navigation?.extras?.state;

    const anggota = state?.['anggota'];
    const nominal = state?.['nominal'];

    if (anggota) {
      this.selectedPinjaman = anggota;
    }
    if (nominal) {
      this.nominalBayar = nominal;
      this.formatAmount();
    }
  }

  formatAmount() {
    this.formattedNominal = this.currencyPipe.transform(
      this.nominalBayar,
      'Rp',
      'symbol',
      '1.0-0'
    ) || 'Rp0';
  }

  pilihBayar(nominal: number) {
    this.nominalBayar = nominal;
    this.formatAmount();
  }

  lanjutKonfirmasi() {
    const token = localStorage.getItem('auth_token');
    const kolektorId = JSON.parse(localStorage.getItem('user') || '{}').id;

    const transaksi = {
      nama: this.selectedPinjaman?.nama,
      jumlah: this.nominalBayar,
      tanggal: new Date().toISOString(),
      metode: this.metodePembayaran,
      hp: this.selectedPinjaman?.hp
    };

    const riwayat = JSON.parse(localStorage.getItem('riwayat_transaksi_kolektor') || '[]');
    riwayat.unshift(transaksi); // Tambah di depan
    localStorage.setItem('riwayat_transaksi_kolektor', JSON.stringify(riwayat));

    this.http.post('http://localhost:8000/api/pembayaran-simpanan/dari-kolektor', {
      anggota_id: this.selectedPinjaman.id,
      pinjaman_id: this.selectedPinjaman.pinjaman_id,
      jumlah: this.nominalBayar,
      metode: this.metodePembayaran,
      tanggal: new Date().toISOString().slice(0, 10), // pastikan format YYYY-MM-DD
      kolektor_id: JSON.parse(localStorage.getItem('user') || '{}').id
    }, {
      headers: {
        Authorization: `Bearer ${token}`
      }
    }).subscribe((res: any) => {
      console.log('Pembayaran dikirim:', res);
      this.router.navigate(['/kolektor']);
    });

  }

}
