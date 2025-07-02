import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { NotifikasiKolektorPageRoutingModule } from './notifikasi-kolektor-routing.module';

import { NotifikasiKolektorPage } from './notifikasi-kolektor.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    NotifikasiKolektorPageRoutingModule
  ],
  declarations: [NotifikasiKolektorPage]
})
export class NotifikasiKolektorPageModule {}
