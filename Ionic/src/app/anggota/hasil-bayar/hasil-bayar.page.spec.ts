import { ComponentFixture, TestBed } from '@angular/core/testing';
import { HasilBayarPage } from './hasil-bayar.page';

describe('HasilBayarPage', () => {
  let component: HasilBayarPage;
  let fixture: ComponentFixture<HasilBayarPage>;

  beforeEach(() => {
    fixture = TestBed.createComponent(HasilBayarPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
