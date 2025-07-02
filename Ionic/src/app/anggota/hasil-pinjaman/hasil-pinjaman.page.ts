import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-hasil-pinjaman',
  templateUrl: './hasil-pinjaman.page.html',
  styleUrls: ['./hasil-pinjaman.page.scss'],
  standalone: false,
})
export class HasilPinjamanPage implements OnInit {
  transferData: any;

  constructor(private router: Router) {
    const navigation = this.router.getCurrentNavigation();
    if (navigation?.extras.state) {
      this.transferData = navigation.extras.state;

      // Format tanggal lebih spesifik
      this.transferData.tanggal = new Date().toLocaleString('id-ID', {
        day: '2-digit',
        month: 'long',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
      }).replace('pukul', '');

      // Format nilai ke Rupiah
      this.transferData.danaDiajukan = this.formatRupiah(this.transferData.danaDiajukan);
      this.transferData.subtotal = this.formatRupiah(this.transferData.subtotal);
    }
  }

  ngOnInit() {
  }

  // Fungsi untuk memformat angka ke format Rupiah
  formatRupiah(amount: number | string): string {
    if (!amount) return 'Rp 0';
    
    const numericAmount = typeof amount === 'string' ? parseFloat(amount) : amount;
    return new Intl.NumberFormat('id-ID', {
      style: 'currency',
      currency: 'IDR',
      minimumFractionDigits: 0
    }).format(numericAmount);
  }

  // Fungsi untuk kembali ke tab1
  kembaliKeHome() {
    this.router.navigate(['/anggota/beranda']);
  }

}
