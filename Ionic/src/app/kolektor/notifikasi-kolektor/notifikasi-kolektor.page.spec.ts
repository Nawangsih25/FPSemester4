import { ComponentFixture, TestBed } from '@angular/core/testing';
import { NotifikasiKolektorPage } from './notifikasi-kolektor.page';

describe('NotifikasiKolektorPage', () => {
  let component: NotifikasiKolektorPage;
  let fixture: ComponentFixture<NotifikasiKolektorPage>;

  beforeEach(() => {
    fixture = TestBed.createComponent(NotifikasiKolektorPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
