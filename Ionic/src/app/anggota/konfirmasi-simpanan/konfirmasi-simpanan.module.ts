import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { KonfirmasiSimpananPageRoutingModule } from './konfirmasi-simpanan-routing.module';

import { KonfirmasiSimpananPage } from './konfirmasi-simpanan.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    KonfirmasiSimpananPageRoutingModule
  ],
  declarations: [KonfirmasiSimpananPage]
})
export class KonfirmasiSimpananPageModule {}
