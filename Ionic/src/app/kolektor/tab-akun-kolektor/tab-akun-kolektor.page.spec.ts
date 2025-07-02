import { ComponentFixture, TestBed } from '@angular/core/testing';
import { TabAkunKolektorPage } from './tab-akun-kolektor.page';

describe('TabAkunKolektorPage', () => {
  let component: TabAkunKolektorPage;
  let fixture: ComponentFixture<TabAkunKolektorPage>;

  beforeEach(() => {
    fixture = TestBed.createComponent(TabAkunKolektorPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
