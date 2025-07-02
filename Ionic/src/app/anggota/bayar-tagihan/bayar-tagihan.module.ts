import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { BayarTagihanPageRoutingModule } from './bayar-tagihan-routing.module';

import { BayarTagihanPage } from './bayar-tagihan.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    BayarTagihanPageRoutingModule
  ],
  declarations: [BayarTagihanPage]
})
export class BayarTagihanPageModule {}
