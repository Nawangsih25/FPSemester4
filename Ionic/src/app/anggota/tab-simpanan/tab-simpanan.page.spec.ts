import { ComponentFixture, TestBed } from '@angular/core/testing';
import { TabSimpananPage } from './tab-simpanan.page';

describe('TabSimpananPage', () => {
  let component: TabSimpananPage;
  let fixture: ComponentFixture<TabSimpananPage>;

  beforeEach(() => {
    fixture = TestBed.createComponent(TabSimpananPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
