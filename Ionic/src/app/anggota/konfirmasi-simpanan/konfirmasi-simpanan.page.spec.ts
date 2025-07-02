import { ComponentFixture, TestBed } from '@angular/core/testing';
import { KonfirmasiSimpananPage } from './konfirmasi-simpanan.page';

describe('KonfirmasiSimpananPage', () => {
  let component: KonfirmasiSimpananPage;
  let fixture: ComponentFixture<KonfirmasiSimpananPage>;

  beforeEach(() => {
    fixture = TestBed.createComponent(KonfirmasiSimpananPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
