import { ComponentFixture, TestBed } from '@angular/core/testing';
import { BayarTagihanPage } from './bayar-tagihan.page';

describe('BayarTagihanPage', () => {
  let component: BayarTagihanPage;
  let fixture: ComponentFixture<BayarTagihanPage>;

  beforeEach(() => {
    fixture = TestBed.createComponent(BayarTagihanPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
