import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { HasilTransferPage } from './hasil-transfer.page';

const routes: Routes = [
  {
    path: '',
    component: HasilTransferPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class HasilTransferPageRoutingModule {}
