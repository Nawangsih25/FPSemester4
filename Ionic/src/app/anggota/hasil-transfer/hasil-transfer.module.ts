import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { HasilTransferPageRoutingModule } from './hasil-transfer-routing.module';

import { HasilTransferPage } from './hasil-transfer.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    HasilTransferPageRoutingModule
  ],
  declarations: [HasilTransferPage]
})
export class HasilTransferPageModule {}
