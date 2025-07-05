import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { HttpClient } from '@angular/common/http';

@Component({
  selector: 'app-tab-anggota',
  templateUrl: './tab-anggota.page.html',
  styleUrls: ['./tab-anggota.page.scss'],
  standalone: false
})
export class TabAnggotaPage implements OnInit {
  // ✅ Letakkan ini di awal class sebagai properti
  anggotaList: any[] = [];

  constructor(
    private router: Router,
    private http: HttpClient
  ) {}

  ngOnInit() {
    const user = JSON.parse(localStorage.getItem('user') || '{}');
    const token = localStorage.getItem('auth_token');

    this.http.get(`http://localhost:8000/api/kolektor/${user.id}/anggota`, {
      headers: { Authorization: `Bearer ${token}` }
    }).subscribe((res: any) => {
      if (res.status === 'success') {
        this.anggotaList = res.anggota;
      }
    });
  }

    gotoBayarAngsuran(anggota: any) {
    this.router.navigate(['/bayar-angsuran'], {
      state: { 
        anggota: anggota,
        nominal: anggota.tagihan_hari_ini
       }
    });
  }
}
