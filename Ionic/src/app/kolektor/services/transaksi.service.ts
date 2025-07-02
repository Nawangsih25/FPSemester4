// services/transaksi.service.ts
import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs';

export interface Transaksi {
  nominal: number;
  formattedNominal: string;
  metodePembayaran: string;
  paymentCode: string;
  tanggal: string;
  status: string;
}

@Injectable({
  providedIn: 'root'
})
export class TransaksiService {
  private riwayatTransaksi: Transaksi[] = [];
  private riwayatSubject = new BehaviorSubject<Transaksi[]>([]);
  
  riwayat$ = this.riwayatSubject.asObservable();

  tambahTransaksi(transaksi: Transaksi) {
    this.riwayatTransaksi.unshift(transaksi); // Tambahkan di awal array
    this.riwayatSubject.next(this.riwayatTransaksi);
    this.simpanKeLocalStorage();
  }

  private simpanKeLocalStorage() {
    localStorage.setItem('riwayat transaksi kolektor', JSON.stringify(this.riwayatTransaksi));
  }

  muatDariLocalStorage() {
    const data = localStorage.getItem('riwayat_transaksi_kolektor');
    if (data) {
      this.riwayatTransaksi = JSON.parse(data);
      this.riwayatSubject.next(this.riwayatTransaksi);
    }
  }
}