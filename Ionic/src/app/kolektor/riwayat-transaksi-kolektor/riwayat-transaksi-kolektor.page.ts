import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
// import { TransaksiService, Transaksi } from '../services/transaksi.service';

@Component({
  selector: 'app-riwayat-transaksi-kolektor',
  templateUrl: './riwayat-transaksi-kolektor.page.html',
  styleUrls: ['./riwayat-transaksi-kolektor.page.scss'],
  standalone: false
})
export class RiwayatTransaksiKolektorPage implements OnInit {
  transaksiList: any[] = [];

  constructor(
    private router : Router,
    // private transaksiService: TransaksiService
  ) { }

  ngOnInit() {
    const riwayat = JSON.parse(localStorage.getItem('riwayat_transaksi_kolektor') || '[]');
    this.transaksiList = riwayat;
  } 

  gotoRincian() {
    this.router.navigate(['/rincian-transaksi']);
  }

}
