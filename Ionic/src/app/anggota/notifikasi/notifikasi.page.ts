import { Component, OnInit } from '@angular/core';
import { NotificationsService } from '../services/notifications.service';
import { HttpClient } from '@angular/common/http';

@Component({
  selector: 'app-notifikasi',
  templateUrl: './notifikasi.page.html',
  styleUrls: ['./notifikasi.page.scss'],
  standalone: false,
})
export class NotifikasiPage implements OnInit {
  notifications: any[] = [];

  constructor(
    private notifService: NotificationsService,
    private http: HttpClient
  ) {}

  ngOnInit() {
    this.loadNotifications();
  }

  loadNotifications() {
    const storedUser = localStorage.getItem('user');
    const user = storedUser ? JSON.parse(storedUser) : null;
    if (!user || !user.id) return;

    this.http.get(`http://localhost:8000/api/notifikasi/${user.id}`).subscribe({
      next: (res: any) => {
        console.log('🔔 NOTIFIKASI RESPONSE:', res); // ⬅️ tambahkan ini
        if (res.success && res.notif) {
          this.notifService.addNotification(res.notif);
        }
        this.notifications = this.notifService.getNotifications();
      },
      error: (err) => {
        console.error('Gagal memuat notifikasi:', err);
        this.notifications = this.notifService.getNotifications(); // fallback data lokal
      }
    });
  }

  markAsRead(id: string) {
    this.notifService.markAsRead(id);
    this.notifications = this.notifService.getNotifications(); // refresh UI
  }
}
