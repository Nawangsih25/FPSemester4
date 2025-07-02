import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { TabAnggotaPageRoutingModule } from './tab-anggota-routing.module';

import { TabAnggotaPage } from './tab-anggota.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    TabAnggotaPageRoutingModule
  ],
  declarations: [TabAnggotaPage]
})
export class TabAnggotaPageModule {}
