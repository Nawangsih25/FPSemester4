import { ComponentFixture, TestBed } from '@angular/core/testing';
import { BayarAngsuranPage } from './bayar-angsuran.page';

describe('BayarAngsuranPage', () => {
  let component: BayarAngsuranPage;
  let fixture: ComponentFixture<BayarAngsuranPage>;

  beforeEach(() => {
    fixture = TestBed.createComponent(BayarAngsuranPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
