import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-riwayat-transaksi',
  templateUrl: './riwayat-transaksi.page.html',
  styleUrls: ['./riwayat-transaksi.page.scss'],
  standalone: false
})
export class RiwayatTransaksiPage implements OnInit {
  transaksiList: any[] = [];

  constructor(
  ) {}

  ngOnInit() {
    const data = JSON.parse(localStorage.getItem('riwayat_transaksi_anggota') || '[]');
    this.transaksiList = data;
  }

}
