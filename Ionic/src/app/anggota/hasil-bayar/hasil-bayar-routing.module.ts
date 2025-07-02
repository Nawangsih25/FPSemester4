import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { HasilBayarPage } from './hasil-bayar.page';

const routes: Routes = [
  {
    path: '',
    component: HasilBayarPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class HasilBayarPageRoutingModule {}
