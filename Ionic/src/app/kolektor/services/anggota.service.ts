// anggota.service.ts
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class AnggotaService {
  anggotaList: any[] = [];

  setAnggota(data: any[]) {
    this.anggotaList = data;
  }

  getAnggota() {
    return this.anggotaList;
  }
}
