import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-rincian-transaksi',
  templateUrl: './rincian-transaksi.page.html',
  styleUrls: ['./rincian-transaksi.page.scss'],
  standalone: false
})
export class RincianTransaksiPage implements OnInit {
  isModalOpen = false;

  constructor() { }

  ngOnInit() {
  }

  openReceiptModal() {
    this.isModalOpen = true;
  }

  closeModal() {
    this.isModalOpen = false;
  }

}
