import { ComponentFixture, TestBed } from '@angular/core/testing';
import { RiwayatTransaksiKolektorPage } from './riwayat-transaksi-kolektor.page';

describe('RiwayatTransaksiKolektorPage', () => {
  let component: RiwayatTransaksiKolektorPage;
  let fixture: ComponentFixture<RiwayatTransaksiKolektorPage>;

  beforeEach(() => {
    fixture = TestBed.createComponent(RiwayatTransaksiKolektorPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
