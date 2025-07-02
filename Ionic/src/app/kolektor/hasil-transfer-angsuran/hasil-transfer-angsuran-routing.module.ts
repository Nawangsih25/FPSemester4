import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { HasilTransferAngsuranPage } from './hasil-transfer-angsuran.page';

const routes: Routes = [
  {
    path: '',
    component: HasilTransferAngsuranPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class HasilTransferAngsuranPageRoutingModule {}
