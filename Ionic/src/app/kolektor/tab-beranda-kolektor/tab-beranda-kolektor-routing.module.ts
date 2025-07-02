import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { TabBerandaKolektorPage } from './tab-beranda-kolektor.page';

const routes: Routes = [
  {
    path: '',
    component: TabBerandaKolektorPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class TabBerandaKolektorPageRoutingModule {}
