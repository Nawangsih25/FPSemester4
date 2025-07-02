import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { BayarAngsuranPageRoutingModule } from './bayar-angsuran-routing.module';

import { BayarAngsuranPage } from './bayar-angsuran.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    BayarAngsuranPageRoutingModule
  ],
  declarations: [BayarAngsuranPage]
})
export class BayarAngsuranPageModule {}
