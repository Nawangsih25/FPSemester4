import { ComponentFixture, TestBed } from '@angular/core/testing';
import { TabLaporanPage } from './tab-laporan.page';

describe('TabLaporanPage', () => {
  let component: TabLaporanPage;
  let fixture: ComponentFixture<TabLaporanPage>;

  beforeEach(() => {
    fixture = TestBed.createComponent(TabLaporanPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
