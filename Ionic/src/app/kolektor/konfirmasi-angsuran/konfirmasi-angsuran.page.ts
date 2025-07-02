import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';// Import jika digunakan
import { TransaksiService, Transaksi } from '../services/transaksi.service';

@Component({
  selector: 'app-konfirmasi-angsuran',
  templateUrl: './konfirmasi-angsuran.page.html',
  styleUrls: ['./konfirmasi-angsuran.page.scss'],
  standalone: false
})
export class KonfirmasiAngsuranPage implements OnInit {
  nominal: number = 0;
  formattedNominal: string = 'Rp0';
  paymentCode: string = '';
  metodePembayaran: string = '';

  constructor(
    private router: Router,
    private transaksiService: TransaksiService
  ) {
    this.getNavigationData();
    const navigation = this.router.getCurrentNavigation();
    const state = navigation?.extras.state as {
      nominal: number;
      formattedNominal: string;
      metodePembayaran: string;
    };

    if (state) {
      this.nominal = state.nominal;
      this.formattedNominal = state.formattedNominal;
      this.metodePembayaran = state.metodePembayaran;
    }}

  ngOnInit() {
    this.generatePaymentCode();
  }

  generatePaymentCode() {
    const timestamp = Date.now().toString().slice(-4);
    const randomDigits = Math.floor(100000 + Math.random() * 900000);
    this.paymentCode = `PAY-${timestamp}-${randomDigits}`;
  }

  private getNavigationData() {
    const navigation = this.router.getCurrentNavigation();
    const state = navigation?.extras.state as {
      nominal: number;
      formattedNominal: string;
      metodePembayaran: string;
    };

    if (state) {
      this.nominal = state.nominal;
      this.formattedNominal = state.formattedNominal;
      this.metodePembayaran = state.metodePembayaran;
    }
  }

  confirmPayment() {
    const transferData: Transaksi = {
      nominal: this.nominal,
      formattedNominal: this.formattedNominal,
      metodePembayaran: this.metodePembayaran,
      paymentCode: this.paymentCode,
      tanggal: new Date().toLocaleString('id-ID', {
        weekday: 'long',
        day: 'numeric',
        month: 'long',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
      }),
      status: 'Berhasil'
    };

    // Simpan ke riwayat transaksi
    this.transaksiService.tambahTransaksi(transferData);

    this.router.navigate(['/hasil-transfer-angsuran'], {
      state: transferData
    });
  }

}
