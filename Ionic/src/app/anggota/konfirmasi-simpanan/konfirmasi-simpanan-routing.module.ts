import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { KonfirmasiSimpananPage } from './konfirmasi-simpanan.page';

const routes: Routes = [
  {
    path: '',
    component: KonfirmasiSimpananPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class KonfirmasiSimpananPageRoutingModule {}
