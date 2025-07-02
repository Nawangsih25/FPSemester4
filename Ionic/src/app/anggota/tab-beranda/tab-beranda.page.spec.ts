import { ComponentFixture, TestBed } from '@angular/core/testing';
import { TabBerandaPage } from './tab-beranda.page';

describe('TabBerandaPage', () => {
  let component: TabBerandaPage;
  let fixture: ComponentFixture<TabBerandaPage>;

  beforeEach(() => {
    fixture = TestBed.createComponent(TabBerandaPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
