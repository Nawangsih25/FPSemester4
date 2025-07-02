import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { BayarAngsuranPage } from './bayar-angsuran.page';

const routes: Routes = [
  {
    path: '',
    component: BayarAngsuranPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class BayarAngsuranPageRoutingModule {}
