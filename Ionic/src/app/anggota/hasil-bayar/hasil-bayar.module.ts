import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { HasilBayarPageRoutingModule } from './hasil-bayar-routing.module';

import { HasilBayarPage } from './hasil-bayar.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    HasilBayarPageRoutingModule
  ],
  declarations: [HasilBayarPage]
})
export class HasilBayarPageModule {}
