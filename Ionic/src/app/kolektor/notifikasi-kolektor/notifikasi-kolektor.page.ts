import { Component, OnInit } from '@angular/core';
import { NotificationsService } from '../services/notifications.service';

@Component({
  selector: 'app-notifikasi-kolektor',
  templateUrl: './notifikasi-kolektor.page.html',
  styleUrls: ['./notifikasi-kolektor.page.scss'],
  standalone: false
})
export class NotifikasiKolektorPage implements OnInit {
  notifications: any[] = [];

  constructor(private notifService: NotificationsService) {}

  ngOnInit() {
    this.loadNotifications();
  }

  loadNotifications() {
    this.notifications = this.notifService.getNotifications();
  }

  markAsRead(id: string) {
    this.notifService.markAsRead(id);
    this.loadNotifications();
  }

}
