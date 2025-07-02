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
  // riwayat: Transaksi[] = [];

  constructor(
    private router : Router,
    // private transaksiService: TransaksiService
  ) { }

  ngOnInit() {
    // this.transaksiService.riwayat$.subscribe(data => {
    //   this.riwayat = data;
    // });
    // this.transaksiService.muatDariLocalStorage();
  }

  gotoRincian() {
    this.router.navigate(['/rincian-transaksi']);
  }

}
