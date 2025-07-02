import { Component, OnInit } from '@angular/core';
import { CurrencyPipe } from '@angular/common';
import { Router } from '@angular/router';

@Component({
  selector: 'app-bayar-angsuran',
  templateUrl: './bayar-angsuran.page.html',
  styleUrls: ['./bayar-angsuran.page.scss'],
  standalone: false,
  providers: [CurrencyPipe],
})
export class BayarAngsuranPage implements OnInit {
  nominalBayar: number | null = null;
  formattedNominal: string = '';
  nominalCepat = [10000, 20000, 50000];

  constructor(
    private currencyPipe: CurrencyPipe,
    private router: Router
  ) {}

  ngOnInit() {
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
    // Validasi jika nominal belum diisi
    if (!this.nominalBayar || this.nominalBayar < 10000) {
      alert('Masukan nominal minimal Rp10.000');
      return;
    }

    // Navigasi ke halaman konfirmasi dengan membawa data
    this.router.navigate(['/konfirmasi-angsuran'], {
      state: {
        nominal: this.nominalBayar,
        formattedNominal: this.formattedNominal
      }
    })
  }

}
