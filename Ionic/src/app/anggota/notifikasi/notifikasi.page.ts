import { Component, OnInit } from '@angular/core';
import { NotificationsService } from '../services/notifications.service';

@Component({
  selector: 'app-notifikasi',
  templateUrl: './notifikasi.page.html',
  styleUrls: ['./notifikasi.page.scss'],
  standalone: false,
})
export class NotifikasiPage implements OnInit {
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