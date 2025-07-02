import { ComponentFixture, TestBed } from '@angular/core/testing';
import { HasilPinjamanPage } from './hasil-pinjaman.page';

describe('HasilPinjamanPage', () => {
  let component: HasilPinjamanPage;
  let fixture: ComponentFixture<HasilPinjamanPage>;

  beforeEach(() => {
    fixture = TestBed.createComponent(HasilPinjamanPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
