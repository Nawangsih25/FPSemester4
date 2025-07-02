import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { RouterModule } from '@angular/router';
import { NotificationsService } from '../services/notifications.service';

import { IonicModule } from '@ionic/angular';

import { TabBerandaPageRoutingModule } from './tab-beranda-routing.module';

import { TabBerandaPage } from './tab-beranda.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    TabBerandaPageRoutingModule,
    RouterModule.forChild([{ path: '', component: TabBerandaPage }])
  ],
  declarations: [TabBerandaPage]
})
export class TabBerandaPageModule {}
