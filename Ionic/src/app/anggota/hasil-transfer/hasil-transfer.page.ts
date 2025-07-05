import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-hasil-transfer',
  templateUrl: './hasil-transfer.page.html',
  styleUrls: ['./hasil-transfer.page.scss'],
  standalone: false,
})
export class HasilTransferPage implements OnInit {
  transferData: any;
  isSimpanan = false;
  isTagihan = false;

  constructor(private router: Router) {
    const navigation = this.router.getCurrentNavigation();
    if (navigation?.extras.state) {
      this.transferData = navigation.extras.state;

      // Identifikasi sumber
      this.isSimpanan = this.transferData.source === 'simpanan';
      this.isTagihan = this.transferData.source === 'tagihan';

      // Format tanggal jika tidak ada
      if (!this.transferData.tanggal) {
        this.transferData.tanggal = new Date().toLocaleString('id-ID', {
          day: '2-digit',
          month: 'long',
          year: 'numeric',
          hour: '2-digit',
          minute: '2-digit'
        }).replace('pukul', '');
      }
    } else {
      this.router.navigate(['/anggota/beranda']);
    }
  }

  ngOnInit() {
    if (!this.transferData) {
      this.router.navigate(['/anggota/beranda']);
    }
  }

  gotoHomePage() {
    this.router.navigate(['/anggota/beranda']);
  }
}
