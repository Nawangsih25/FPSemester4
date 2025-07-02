import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { TabSimpananPage } from './tab-simpanan.page';

const routes: Routes = [
  {
    path: '',
    component: TabSimpananPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class TabSimpananPageRoutingModule {}
