import { ComponentFixture, TestBed } from '@angular/core/testing';
import { KonfirmasiAngsuranPage } from './konfirmasi-angsuran.page';

describe('KonfirmasiAngsuranPage', () => {
  let component: KonfirmasiAngsuranPage;
  let fixture: ComponentFixture<KonfirmasiAngsuranPage>;

  beforeEach(() => {
    fixture = TestBed.createComponent(KonfirmasiAngsuranPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
