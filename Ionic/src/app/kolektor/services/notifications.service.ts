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

  addNotification(notification: any) {
    this.notifications.unshift({
      ...notification,
      id: Date.now().toString(),
      date: new Date(),
      read: false
    });
  }
}