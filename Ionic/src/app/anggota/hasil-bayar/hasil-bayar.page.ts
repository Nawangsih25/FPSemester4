import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-hasil-bayar',
  templateUrl: './hasil-bayar.page.html',
  styleUrls: ['./hasil-bayar.page.scss'],
  standalone: false,
})
export class HasilBayarPage implements OnInit {
  paymentData: any;

  constructor(private router: Router) {
    const navigation = this.router.getCurrentNavigation();
    if (navigation?.extras.state) {
      this.paymentData = navigation.extras.state['data'];
    }
  }

  ngOnInit() {
    if (!this.paymentData) {
      // Jika tidak ada data, redirect kembali
      this.router.navigate(['/bayar-tagihan']);
    }
  }

  getPaymentMethodName(methodCode: string): string {
    const methods: {[key: string]: string} = {
      'bni': 'BNI',
      'bjb': 'BJB',
      'mandiri': 'Mandiri',
      'dana': 'DANA',
      'gopay': 'GoPay',
      'ovo': 'OVO'
    };
    return methods[methodCode] || methodCode;
  }

  gotoHomePage() {
    this.router.navigate(['/anggota/beranda']);
  }

}
