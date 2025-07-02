import { ComponentFixture, TestBed } from '@angular/core/testing';
import { TabBerandaKolektorPage } from './tab-beranda-kolektor.page';

describe('TabBerandaKolektorPage', () => {
  let component: TabBerandaKolektorPage;
  let fixture: ComponentFixture<TabBerandaKolektorPage>;

  beforeEach(() => {
    fixture = TestBed.createComponent(TabBerandaKolektorPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
