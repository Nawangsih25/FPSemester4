import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { NotificationsService } from '../services/notifications.service';

@Component({
  selector: 'app-tab-beranda-kolektor',
  templateUrl: './tab-beranda-kolektor.page.html',
  styleUrls: ['./tab-beranda-kolektor.page.scss'],
  standalone: false
})
export class TabBerandaKolektorPage implements OnInit {
  unreadCount = 0;

  constructor(
    private router: Router,
    private notifService: NotificationsService
  ) { }

  ngOnInit() {
    this.updateBadgeCount();
  }

  ionViewWillEnter() {
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
    this.router.navigate(['/bayar-angsuran'])
  }

  gotoRincian() {
    this.router.navigate(['/rincian-transaksi']);
  }

}
