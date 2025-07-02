import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { TabLaporanPageRoutingModule } from './tab-laporan-routing.module';

import { TabLaporanPage } from './tab-laporan.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    TabLaporanPageRoutingModule
  ],
  declarations: [TabLaporanPage]
})
export class TabLaporanPageModule {}
