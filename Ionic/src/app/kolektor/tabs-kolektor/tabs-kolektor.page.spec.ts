import { ComponentFixture, TestBed } from '@angular/core/testing';
import { TabsKolektorPage } from './tabs-kolektor.page';

describe('TabsKolektorPage', () => {
  let component: TabsKolektorPage;
  let fixture: ComponentFixture<TabsKolektorPage>;

  beforeEach(() => {
    fixture = TestBed.createComponent(TabsKolektorPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
