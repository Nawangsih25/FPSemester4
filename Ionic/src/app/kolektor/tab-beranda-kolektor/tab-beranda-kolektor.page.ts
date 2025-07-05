import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { NotificationsService } from '../services/notifications.service';
import { HttpClient } from '@angular/common/http';

@Component({
  selector: 'app-tab-beranda-kolektor',
  templateUrl: './tab-beranda-kolektor.page.html',
  styleUrls: ['./tab-beranda-kolektor.page.scss'],
  standalone: false
})
export class TabBerandaKolektorPage implements OnInit {
  transaksiList: any[] = [];
  unreadCount = 0;
  kolektor: any = {};
  totalTagihanAnggota: number = 0;
  totalPinjaman: number = 0;
  totalDibayar: number = 0;
  totalAnggota: number = 0;
  anggotaList: any[] = []; // 🆕 Menyimpan daftar anggota yang dinaungi kolektor

  constructor(
    private router: Router,
    private notifService: NotificationsService,
    private http: HttpClient
  ) {}

  ngOnInit() {
    this.fetchDashboardData();
    this.updateBadgeCount();
    this.loadKolektorData();
    this.loadAnggota(); // 🆕 Panggil fungsi ambil data anggota
    const riwayat = JSON.parse(localStorage.getItem('riwayat_transaksi_kolektor') || '[]');
    this.transaksiList = riwayat;
  }

  ionViewWillEnter() {
    const user = JSON.parse(localStorage.getItem('user') || '{}');
    const kolektorId = user.id;
    const token = localStorage.getItem('auth_token');

    if (!kolektorId) {
      console.error('ID Kolektor tidak ditemukan di localStorage!');
      return;
    }

    this.http.get(`http://localhost:8000/api/kolektor/dashboard/${kolektorId}`).subscribe((res: any) => {
      this.totalAnggota = res.total_anggota;
    });
    this.updateBadgeCount();
  }

  updateBadgeCount() {
    this.unreadCount = this.notifService.getUnreadCount();
  }

  gotoNotifikasi() {
    this.router.navigate(['/notifikasi-kolektor']);
  }

  gotoRiwayat() {
    this.router.navigate(['/riwayat-transaksi-kolektor']);
  }

  gotoBayarAngsuran() {
    this.router.navigate(['kolektor/anggota']);
  }

  gotoRincian() {
    this.router.navigate(['/rincian-transaksi']);
  }

  loadKolektorData() {
    const user = JSON.parse(localStorage.getItem('user') || '{}');
    const token = localStorage.getItem('auth_token');

    if (!user?.id || !token) return;

    this.http.get(`http://localhost:8000/api/kolektor/${user.id}`, {
      headers: { Authorization: `Bearer ${token}` }
    }).subscribe((res: any) => {
      if (res.status === 'success') {
        this.kolektor = res.kolektor;
      }
    });
  }

  fetchDashboardData() {
    const user = JSON.parse(localStorage.getItem('user') || '{}');
    const kolektorId = user.id;
    const token = localStorage.getItem('auth_token');

    console.log('Token:', token); // Debug token
    if (!kolektorId) {
      console.error('ID Kolektor tidak ditemukan di fetchDashboardData()');
      return;
    }

    this.http.get(`http://localhost:8000/api/kolektor/dashboard/${kolektorId}`)
      .subscribe({
        next: (res: any) => {
          console.log('Total Dibayar:', res.total_tagihan_dibayar);
          if (res.status === 'success' || res.total_tagihan_dibayar !== undefined) {
            this.totalDibayar = res.total_tagihan_dibayar;
            this.totalAnggota = res.total_anggota;
            this.totalPinjaman = res.total_pinjaman;
            this.totalTagihanAnggota = res.total_tagihan_bulan_ini;
          } else {
            console.error('Respon tidak success:', res);
          }
        },
        error: (err) => {
          console.error('Terjadi error:', err);
        }
      });
  }


  // 🆕 Ambil data anggota berdasarkan ID kolektor
  loadAnggota() {
    const user = JSON.parse(localStorage.getItem('user') || '{}');
    const token = localStorage.getItem('auth_token');
    const kolektorId = user.id;

     this.http.get(`http://localhost:8000/api/kolektor/${kolektorId}/anggota`, {
        headers: {
          Authorization: `Bearer ${token}`
        }
      }).subscribe((res: any) => {
        if (res.status === 'success') {
          this.anggotaList = res.anggota;
        }
      });
  }

  getNamaKolektor(): string {
    return this.kolektor?.nama || 'Nama Pengguna';
  }
}
