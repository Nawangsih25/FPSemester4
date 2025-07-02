import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { NotifikasiKolektorPage } from './notifikasi-kolektor.page';

const routes: Routes = [
  {
    path: '',
    component: NotifikasiKolektorPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class NotifikasiKolektorPageRoutingModule {}
