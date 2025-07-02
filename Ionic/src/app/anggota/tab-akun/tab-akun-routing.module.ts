import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { TabAkunPage } from './tab-akun.page';

const routes: Routes = [
  {
    path: '',
    component: TabAkunPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class TabAkunPageRoutingModule {}
