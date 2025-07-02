import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { RiwayatTransaksiKolektorPageRoutingModule } from './riwayat-transaksi-kolektor-routing.module';

import { RiwayatTransaksiKolektorPage } from './riwayat-transaksi-kolektor.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    RiwayatTransaksiKolektorPageRoutingModule
  ],
  declarations: [RiwayatTransaksiKolektorPage],
})
export class RiwayatTransaksiKolektorPageModule {}
