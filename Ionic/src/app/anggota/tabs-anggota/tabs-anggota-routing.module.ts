import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { TabsAnggotaPage } from './tabs-anggota.page';

const routes: Routes = [
  {
    path: '',
    component: TabsAnggotaPage,
    children: [
      {
        path: 'beranda',
        loadChildren: () => import('../tab-beranda/tab-beranda.module').then(m => m.TabBerandaPageModule)
      },
      {
        path: 'simpanan',
        loadChildren: () => import('../tab-simpanan/tab-simpanan.module').then(m => m.TabSimpananPageModule)
      },
      {
        path: 'pinjaman',
        loadChildren: () => import('../tab-pinjaman/tab-pinjaman.module').then(m => m.TabPinjamanPageModule)
      },
      {
        path: 'akun',
        loadChildren: () => import('../tab-akun/tab-akun.module').then(m => m.TabAkunPageModule)
      },
      {
        path: '',
        redirectTo: 'beranda',
        pathMatch: 'full'
      }
    ]
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class TabsAnggotaPageRoutingModule { }