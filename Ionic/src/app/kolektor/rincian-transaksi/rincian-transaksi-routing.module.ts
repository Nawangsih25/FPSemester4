import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { RincianTransaksiPage } from './rincian-transaksi.page';

const routes: Routes = [
  {
    path: '',
    component: RincianTransaksiPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class RincianTransaksiPageRoutingModule {}
