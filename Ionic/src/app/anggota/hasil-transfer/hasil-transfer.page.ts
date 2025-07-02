import { Component } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-hasil-transfer',
  templateUrl: './hasil-transfer.page.html',
  styleUrls: ['./hasil-transfer.page.scss'],
  standalone: false,
})
export class HasilTransferPage {
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
    }
  }

  gotoHomePage() {
    this.router.navigate(['/anggota/beranda']); // Kembali ke home
  }

}