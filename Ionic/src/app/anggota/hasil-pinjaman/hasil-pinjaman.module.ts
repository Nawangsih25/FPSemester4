import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { HasilPinjamanPageRoutingModule } from './hasil-pinjaman-routing.module';

import { HasilPinjamanPage } from './hasil-pinjaman.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    HasilPinjamanPageRoutingModule
  ],
  declarations: [HasilPinjamanPage]
})
export class HasilPinjamanPageModule {}
