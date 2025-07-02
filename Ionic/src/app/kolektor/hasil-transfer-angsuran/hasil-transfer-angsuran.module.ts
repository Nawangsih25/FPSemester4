import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { HasilTransferAngsuranPageRoutingModule } from './hasil-transfer-angsuran-routing.module';

import { HasilTransferAngsuranPage } from './hasil-transfer-angsuran.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    HasilTransferAngsuranPageRoutingModule
  ],
  declarations: [HasilTransferAngsuranPage]
})
export class HasilTransferAngsuranPageModule {}
