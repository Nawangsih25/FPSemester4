import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { NotificationsService } from '../services/notifications.service';

@Component({
  selector: 'app-tab-beranda',
  templateUrl: './tab-beranda.page.html',
  styleUrls: ['./tab-beranda.page.scss'],
  standalone: false
})
export class TabBerandaPage implements OnInit {
  showSaldo = false;
  unreadCount = 0;

  constructor(
    private router : Router,
    private notifService: NotificationsService
  ) {}
  
  ngOnInit() {
    this.updateBadgeCount();
  }

  ionViewWillEnter() {
    this.updateBadgeCount();
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

}
