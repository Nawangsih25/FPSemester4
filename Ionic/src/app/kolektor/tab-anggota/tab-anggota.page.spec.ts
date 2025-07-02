import { ComponentFixture, TestBed } from '@angular/core/testing';
import { TabAnggotaPage } from './tab-anggota.page';

describe('TabAnggotaPage', () => {
  let component: TabAnggotaPage;
  let fixture: ComponentFixture<TabAnggotaPage>;

  beforeEach(() => {
    fixture = TestBed.createComponent(TabAnggotaPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
