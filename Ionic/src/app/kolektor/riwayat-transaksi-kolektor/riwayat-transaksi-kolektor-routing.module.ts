import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { RiwayatTransaksiKolektorPage } from './riwayat-transaksi-kolektor.page';

const routes: Routes = [
  {
    path: '',
    component: RiwayatTransaksiKolektorPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class RiwayatTransaksiKolektorPageRoutingModule {}
