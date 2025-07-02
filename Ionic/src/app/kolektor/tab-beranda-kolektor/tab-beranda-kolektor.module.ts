import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { TabBerandaKolektorPageRoutingModule } from './tab-beranda-kolektor-routing.module';

import { TabBerandaKolektorPage } from './tab-beranda-kolektor.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    TabBerandaKolektorPageRoutingModule
  ],
  declarations: [TabBerandaKolektorPage]
})
export class TabBerandaKolektorPageModule {}
