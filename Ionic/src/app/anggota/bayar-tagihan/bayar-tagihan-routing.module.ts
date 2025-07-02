import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { BayarTagihanPage } from './bayar-tagihan.page';

const routes: Routes = [
  {
    path: '',
    component: BayarTagihanPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class BayarTagihanPageRoutingModule {}
