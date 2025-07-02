import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { TabAnggotaPage } from './tab-anggota.page';

const routes: Routes = [
  {
    path: '',
    component: TabAnggotaPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class TabAnggotaPageRoutingModule {}
