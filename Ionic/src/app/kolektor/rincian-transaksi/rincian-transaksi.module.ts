import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { RincianTransaksiPageRoutingModule } from './rincian-transaksi-routing.module';

import { RincianTransaksiPage } from './rincian-transaksi.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    RincianTransaksiPageRoutingModule
  ],
  declarations: [RincianTransaksiPage]
})
export class RincianTransaksiPageModule {}
