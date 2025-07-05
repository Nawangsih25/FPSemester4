import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { NotificationsService } from '../services/notifications.service';
import { HttpClient } from '@angular/common/http';

@Component({
  selector: 'app-tab-beranda',
  templateUrl: './tab-beranda.page.html',
  styleUrls: ['./tab-beranda.page.scss'],
  standalone: false
})
export class TabBerandaPage implements OnInit {
  transaksiList: any[] = [];
  user: any;
  showSaldo = false;
  unreadCount = 0;
  pinjamanAktif = 0;
  limitPinjaman = 0;
  saldoSukarela = 0;
  pinjamanTerpakai = 0;
  riwayat: any[] = [];

  constructor(
    private router : Router,
    private notifService: NotificationsService,
    private http: HttpClient
  ) {}
  
  ngOnInit() {
    const storedUser = localStorage.getItem('user');
    if (storedUser) {
      this.user = JSON.parse(storedUser);
    }
    
    const data = JSON.parse(localStorage.getItem('riwayat_transaksi_anggota') || '[]');
    this.transaksiList = data;
  
    this.updateBadgeCount();
    this.loadPinjamanAktif();
    this.loadBerandaData();
    this.loadNotifikasi();
  }

  ionViewWillEnter() {
    this.updateBadgeCount();
    this.loadPinjamanAktif();
    this.loadBerandaData();
    this.loadNotifikasi();
  }

  updateBadgeCount() {
    this.unreadCount = this.notifService.getUnreadCount();
  }

  toggleSaldo() {
    this.showSaldo = !this.showSaldo;
  }

  gotoNotifikasi() {
    this.router.navigate(['/notifikasi']);
  }

  gotoRiwayat() {
    this.router.navigate(['/riwayat-transaksi']);
  }

  gotoBayarTagihan() {
    this.router.navigate(['/bayar-tagihan']);
  }

  loadPinjamanAktif() {
    const user = JSON.parse(localStorage.getItem('user') || '{}');
    const anggotaId = user?.id;

    this.http.get<any>(`http://localhost:8000/api/pinjaman-aktif/${anggotaId}`).subscribe(res => {
      if (res.status === 'success') {
        this.pinjamanAktif = res.data;
      }
    });
  }

  loadBerandaData() {
    const user = JSON.parse(localStorage.getItem('user') || '{}');
    const anggotaId = user?.id;

    this.http.get<any>(`http://localhost:8000/api/beranda-data/${anggotaId}`).subscribe(res => {
      if (res.status === 'success') {
        this.limitPinjaman = res.data.limit_pinjaman;
        this.saldoSukarela = res.data.saldo_sukarela;
        this.pinjamanTerpakai = res.data.pinjaman_terpakai;
        this.riwayat = res.data.riwayat.slice(0, 2);
      }
    });
  }

  loadNotifikasi() {
    const anggotaId = this.user?.id;

    this.http.get<any>(`http://localhost:8000/api/notifikasi/${anggotaId}`).subscribe(res => {
      if (res.success && res.notif) {
        this.notifService.addNotification(res.notif);
        this.updateBadgeCount();
      }
    });
  }



}
