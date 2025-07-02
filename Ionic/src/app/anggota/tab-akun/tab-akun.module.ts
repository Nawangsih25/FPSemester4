import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { TabAkunPageRoutingModule } from './tab-akun-routing.module';

import { TabAkunPage } from './tab-akun.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    TabAkunPageRoutingModule
  ],
  declarations: [TabAkunPage]
})
export class TabAkunPageModule {}
