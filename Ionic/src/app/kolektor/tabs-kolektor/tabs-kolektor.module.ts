import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { TabsKolektorPageRoutingModule } from './tabs-kolektor-routing.module';

import { TabsKolektorPage } from './tabs-kolektor.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    TabsKolektorPageRoutingModule
  ],
  declarations: [TabsKolektorPage]
})
export class TabsKolektorPageModule {}
