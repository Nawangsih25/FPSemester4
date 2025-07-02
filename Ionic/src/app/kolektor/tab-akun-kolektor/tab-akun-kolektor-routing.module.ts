import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { TabAkunKolektorPage } from './tab-akun-kolektor.page';

const routes: Routes = [
  {
    path: '',
    component: TabAkunKolektorPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class TabAkunKolektorPageRoutingModule {}
