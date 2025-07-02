import { Component } from '@angular/core';
import { CurrencyPipe } from '@angular/common';
import { Router } from '@angular/router';


@Component({
  selector: 'app-tab-simpanan',
  templateUrl: './tab-simpanan.page.html',
  styleUrls: ['./tab-simpanan.page.scss'],
  standalone: false
})
export class TabSimpananPage {
  segment = 'wajib'; //sebagai default
  
  constructor(
    private currencyPipe: CurrencyPipe,
    private router: Router
  ) {}
  
  segmentChanged(ev: any) {
    this.segment = ev.detail.value;
  }

  nominalSimpan: number | null = null;
  formattedNominal: string = '';
  nominalCepat = [10000, 20000, 50000];
  selectedMetodePembayaran: string = '';

  formatAmount() {
    // Format ke Rupiah
    this.formattedNominal = this.currencyPipe.transform(
      this.nominalSimpan, 
      'Rp', 
      'symbol', 
      '1.0-0'
    ) || 'Rp0';
  }
  
  pilihSimpan(nominal: number) {
    this.nominalSimpan = nominal;
    this.formatAmount();
  }

  lanjutKonfirmasi() {
    // if (!this.selectedMetodePembayaran) {
    // alert('Silakan pilih metode pembayaran terlebih dahulu');
    // return;
    // }

    // Validasi jika nominal belum diisi
    if (!this.nominalSimpan || this.nominalSimpan < 10000) {
      alert('Masukkan nominal minimal Rp10.000');
      return;
    }
    
    // Navigasi ke halaman konfirmasi dengan membawa data
    this.router.navigate(['/konfirmasi-simpanan'], {
      state: {
        nominal: this.nominalSimpan,
        jenisSimpanan: this.segment,
        formattedNominal: this.formattedNominal,
        metodePembayaran: this.selectedMetodePembayaran
      }
    });
  }

}
