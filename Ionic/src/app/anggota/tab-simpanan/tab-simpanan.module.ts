import { NgModule } from '@angular/core';
import { CommonModule, CurrencyPipe } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { TabSimpananPageRoutingModule } from './tab-simpanan-routing.module';

import { TabSimpananPage } from './tab-simpanan.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    TabSimpananPageRoutingModule
  ],
  declarations: [TabSimpananPage],
  providers: [CurrencyPipe]
})
export class TabSimpananPageModule {}
