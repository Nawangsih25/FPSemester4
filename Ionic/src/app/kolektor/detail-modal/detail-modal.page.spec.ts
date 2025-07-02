import { ComponentFixture, TestBed } from '@angular/core/testing';
import { DetailModalPage } from './detail-modal.page';

describe('DetailModalPage', () => {
  let component: DetailModalPage;
  let fixture: ComponentFixture<DetailModalPage>;

  beforeEach(() => {
    fixture = TestBed.createComponent(DetailModalPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
