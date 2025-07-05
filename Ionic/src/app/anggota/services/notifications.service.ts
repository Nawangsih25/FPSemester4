import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class NotificationsService {
  private notifications: any[] = [
    {
      id: '1',
      title: 'Transfer Berhasil',
      message: 'Transfer sebesar Rp50.000 ke rekening BNI telah berhasil',
      date: new Date(),
      read: false
    },
    {
      id: '2',
      title: 'Pembayaran Diterima',
      message: 'Pembayaran simpanan wajib Rp20.000 telah diterima',
      date: new Date(Date.now() - 86400000), // 1 hari yang lalu
      read: true
    }
  ];

  constructor() {}

  getNotifications() {
    return [...this.notifications];
  }

  getUnreadCount() {
    return this.notifications.filter(n => !n.read).length;
  }

  markAsRead(id: string) {
    const notif = this.notifications.find(n => n.id === id);
    if (notif) {
      notif.read = true;
    }
  }

  /**
   * Tambahkan notifikasi baru dari backend atau lokal
   * @param notification {
   *   title: string,
   *   message: string,
   *   date?: string | Date
   * }
   */

  addNotification(notification: { title: string; message: string; date?: string | Date }) {
    const newNotif = {
      id: Date.now().toString(),
      title: notification.title,
      message: notification.message,
      date: notification.date ? new Date(notification.date) : new Date(),
      read: false
    };
    this.notifications.unshift(newNotif);
  }
}