import { TestBed } from '@angular/core/testing';

import { AnggotaService } from './anggota.service';

describe('AnggotaService', () => {
  let service: AnggotaService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(AnggotaService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
