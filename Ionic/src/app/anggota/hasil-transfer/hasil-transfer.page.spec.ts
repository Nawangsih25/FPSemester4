import { ComponentFixture, TestBed } from '@angular/core/testing';
import { HasilTransferPage } from './hasil-transfer.page';

describe('HasilTransferPage', () => {
  let component: HasilTransferPage;
  let fixture: ComponentFixture<HasilTransferPage>;

  beforeEach(() => {
    fixture = TestBed.createComponent(HasilTransferPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
