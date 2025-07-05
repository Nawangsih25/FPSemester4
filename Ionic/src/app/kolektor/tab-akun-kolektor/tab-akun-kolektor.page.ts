import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-tab-akun-kolektor',
  templateUrl: './tab-akun-kolektor.page.html',
  styleUrls: ['./tab-akun-kolektor.page.scss'],
  standalone: false
})
export class TabAkunKolektorPage implements OnInit {
  user: any;
  role: string = '';


  constructor(private router: Router) { }

  ngOnInit() {
    const storedUser = localStorage.getItem('user');
    if (storedUser) {
      this.user = JSON.parse(storedUser);
    }
    this.role = localStorage.getItem('role') || '';
  }

  logout() {
    // Hapus data dari localStorage
    localStorage.removeItem('token');
    localStorage.removeItem('user');
    localStorage.removeItem('role');

    // Redirect ke halaman login
    this.router.navigate(['/login']);
  }
}
