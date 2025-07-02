import { Component, OnInit, Input } from '@angular/core';
import { ModalController } from '@ionic/angular';

@Component({
  selector: 'app-detail-modal',
  templateUrl: './detail-modal.page.html',
  styleUrls: ['./detail-modal.page.scss'],
  standalone: false
})
export class DetailModalPage implements OnInit {
  @Input() anggotaData: any; // Terima data dari halaman utama

  constructor(private modalCtrl: ModalController) { }

  closeModal() {
    this.modalCtrl.dismiss();
  }

  ngOnInit() {
  }

}
