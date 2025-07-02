import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';// Import jika digunakan

@Component({
  selector: 'app-konfirmasi-simpanan',
  templateUrl: './konfirmasi-simpanan.page.html',
  styleUrls: ['./konfirmasi-simpanan.page.scss'],
  standalone: false,
})
export class KonfirmasiSimpananPage implements OnInit {
  nominal: number = 0;
  jenisSimpanan: string = '';
  formattedNominal: string = 'Rp0';
  paymentCode: string = '';
  metodePembayaran: string = '';

  constructor(
    private router: Router,
  ) {
    const navigation = this.router.getCurrentNavigation();
    const state = navigation?.extras.state as {
      nominal: number;
      jenisSimpanan: string;
      formattedNominal: string;
      metodePembayaran: string;
    };

    if (state) {
      this.nominal = state.nominal;
      this.jenisSimpanan = state.jenisSimpanan;
      this.formattedNominal = state.formattedNominal;
      this.metodePembayaran = state.metodePembayaran;
    }
  }

  ngOnInit() {
    this.generatePaymentCode();
  }

  generatePaymentCode() {
    const randomDigits = Math.floor(100000000000 + Math.random() * 900000000000);
    this.paymentCode = `${randomDigits.toString().slice(0, 12)}`;
  }

  confirmPayment() {
    const transferData = {
      nominal: this.nominal,
      jenisSimpanan: this.jenisSimpanan,
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

    this.router.navigate(['/hasil-transfer'], {
      state: transferData
    });
  }

  goBack() {
    this.router.navigate(['/tabs/tab2']);
  }
}