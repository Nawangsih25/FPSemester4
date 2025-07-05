import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Router } from '@angular/router';

@Component({
  selector: 'app-login',
  templateUrl: './login.page.html',
  styleUrls: ['./login.page.scss'],
  standalone: false
})
export class LoginPage {
  nik: string = '';
  nama: string = '';

  ngOnInit() {
    const token = localStorage.getItem('auth_token');
    if (!token) {
      alert('Anda harus login terlebih dahulu.');
      this.router.navigate(['/login']);
    }
  }

  constructor(private http: HttpClient, private router: Router) {}

  login() {
    this.http.post('http://localhost:8000/api/login', {
      nik: this.nik,
      nama: this.nama
    }).subscribe(
      (res: any) => {
        if (res.status === 'success') {
          localStorage.setItem('auth_token', res.token);
          localStorage.setItem('user', JSON.stringify(res.user));
          localStorage.setItem('role', res.role);

          // ✅ Format yang dibutuhkan oleh notifikasi
          localStorage.setItem('user', JSON.stringify({
            id: res.user_id,
            nama: res.user_nama,
            role: res.user_role
          }));

          localStorage.setItem('role', res.role);

          (document.activeElement as HTMLElement)?.blur();

          if (res.role === 'anggota') {
            this.router.navigate(['/anggota']);
          } else if (res.role === 'kolektor') {
            this.router.navigate(['/kolektor']);
          }

          // 👉 Blur tombol aktif agar tidak terjadi konflik dengan aria-hidden
          (document.activeElement as HTMLElement)?.blur();

          // 👉 Lanjut navigasi setelah blur
          if (res.role === 'anggota') {
            this.router.navigate(['/anggota']);
          } else if (res.role === 'kolektor') {
            this.router.navigate(['/kolektor']);
          }
        } else {
          alert('Login gagal: ' + res.message);
        }
      },
      error => {
        alert('Terjadi kesalahan saat login.');
      }
    );
  }
}
