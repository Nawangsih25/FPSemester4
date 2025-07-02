import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { TabPinjamanPageRoutingModule } from './tab-pinjaman-routing.module';

import { TabPinjamanPage } from './tab-pinjaman.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    TabPinjamanPageRoutingModule
  ],
  declarations: [TabPinjamanPage]
})
export class TabPinjamanPageModule {}
