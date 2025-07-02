import { ComponentFixture, TestBed } from '@angular/core/testing';
import { TabPinjamanPage } from './tab-pinjaman.page';

describe('TabPinjamanPage', () => {
  let component: TabPinjamanPage;
  let fixture: ComponentFixture<TabPinjamanPage>;

  beforeEach(() => {
    fixture = TestBed.createComponent(TabPinjamanPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
