import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { TabsKolektorPage } from './tabs-kolektor.page';

const routes: Routes = [
  {
    path: '',
    component: TabsKolektorPage,
    children: [
      {
        path: 'beranda-kolektor',
        loadChildren: () => import('../tab-beranda-kolektor/tab-beranda-kolektor.module').then(m => m.TabBerandaKolektorPageModule)
      },
      {
        path: 'anggota',
        loadChildren: () => import('../tab-anggota/tab-anggota.module').then(m => m.TabAnggotaPageModule)
      },
      {
        path: 'laporan',
        loadChildren: () => import('../tab-laporan/tab-laporan.module').then(m => m.TabLaporanPageModule)
      },
      {
        path: 'akun-kolektor',
        loadChildren: () => import('../tab-akun-kolektor/tab-akun-kolektor.module').then(m => m.TabAkunKolektorPageModule)
      },
      {
        path: '',
        redirectTo: 'beranda-kolektor',
        pathMatch: 'full'
      }
    ]
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class TabsKolektorPageRoutingModule {}
