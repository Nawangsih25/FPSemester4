import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { TabBerandaPage } from './tab-beranda.page';

const routes: Routes = [
  {
    path: '',
    component: TabBerandaPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class TabBerandaPageRoutingModule {}
