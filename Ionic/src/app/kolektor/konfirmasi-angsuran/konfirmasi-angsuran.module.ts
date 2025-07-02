import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { KonfirmasiAngsuranPageRoutingModule } from './konfirmasi-angsuran-routing.module';

import { KonfirmasiAngsuranPage } from './konfirmasi-angsuran.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    KonfirmasiAngsuranPageRoutingModule
  ],
  declarations: [KonfirmasiAngsuranPage]
})
export class KonfirmasiAngsuranPageModule {}
