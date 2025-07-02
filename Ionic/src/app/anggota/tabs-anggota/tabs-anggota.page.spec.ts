import { ComponentFixture, TestBed } from '@angular/core/testing';
import { TabsAnggotaPage } from './tabs-anggota.page';

describe('TabsAnggotaPage', () => {
  let component: TabsAnggotaPage;
  let fixture: ComponentFixture<TabsAnggotaPage>;

  beforeEach(() => {
    fixture = TestBed.createComponent(TabsAnggotaPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
