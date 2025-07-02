import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { TabsAnggotaPageRoutingModule } from './tabs-anggota-routing.module';

import { TabsAnggotaPage } from './tabs-anggota.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    TabsAnggotaPageRoutingModule
  ],
  declarations: [TabsAnggotaPage]
})
export class TabsAnggotaPageModule {}
