import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { TabLaporanPage } from './tab-laporan.page';

const routes: Routes = [
  {
    path: '',
    component: TabLaporanPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class TabLaporanPageRoutingModule {}
