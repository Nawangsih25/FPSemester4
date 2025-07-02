import { ComponentFixture, TestBed } from '@angular/core/testing';
import { RincianTransaksiPage } from './rincian-transaksi.page';

describe('RincianTransaksiPage', () => {
  let component: RincianTransaksiPage;
  let fixture: ComponentFixture<RincianTransaksiPage>;

  beforeEach(() => {
    fixture = TestBed.createComponent(RincianTransaksiPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
