import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { TabPinjamanPage } from './tab-pinjaman.page';

const routes: Routes = [
  {
    path: '',
    component: TabPinjamanPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class TabPinjamanPageRoutingModule {}
