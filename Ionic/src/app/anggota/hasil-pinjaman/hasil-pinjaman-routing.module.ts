import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { HasilPinjamanPage } from './hasil-pinjaman.page';

const routes: Routes = [
  {
    path: '',
    component: HasilPinjamanPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class HasilPinjamanPageRoutingModule {}
