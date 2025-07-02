import { ComponentFixture, TestBed } from '@angular/core/testing';
import { TabAkunPage } from './tab-akun.page';

describe('TabAkunPage', () => {
  let component: TabAkunPage;
  let fixture: ComponentFixture<TabAkunPage>;

  beforeEach(() => {
    fixture = TestBed.createComponent(TabAkunPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
