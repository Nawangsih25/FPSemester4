import { Component, OnInit } from '@angular/core';
import { CurrencyPipe } from '@angular/common';
import { Router } from '@angular/router';
import { HttpClient } from '@angular/common/http';


@Component({
  selector: 'app-tab-simpanan',
  templateUrl: './tab-simpanan.page.html',
  styleUrls: ['./tab-simpanan.page.scss'],
  standalone: false
})
export class TabSimpananPage implements OnInit {
  user: any;
  saldoSukarela = 0;
  saldoWajib = 0;
  segment = 'wajib'; //sebagai default
  metodePembayaranList = [
    { value: 'bni', label: 'Bank BNI', rekening: '1234567890' },
    { value: 'bjb', label: 'Bank BJB', rekening: '9876543210' },
    { value: 'mandiri', label: 'Bank Mandiri', rekening: '1122334455' },
    { value: 'dana', label: 'Dana', rekening: '081234567890' },
    { value: 'gopay', label: 'Gopay', rekening: '081212121212' },
    { value: 'ovo', label: 'Ovo', rekening: '082233445566' }
  ];
  
  constructor(
    private currencyPipe: CurrencyPipe,
    private router: Router,
    private http: HttpClient
  ) {}

  ngOnInit() {
    const storedUser = localStorage.getItem('user');
    if (storedUser) {
      this.user = JSON.parse(storedUser);
    }

    // Default untuk segment wajib
    if (this.segment === 'wajib') {
      this.nominalSimpan = 50000;
      this.formatAmount();
    }
    
    this.loadBerandaData();
  }

  ionViewWillEnter() {
    this.loadBerandaData();
  }
  
  segmentChanged(ev: any) {
    this.segment = ev.detail.value;

    if (this.segment === 'wajib') {
      this.nominalSimpan = 50000;
      this.formatAmount();
    } else {
      this.nominalSimpan = null;
      this.formattedNominal = 'Rp0';
    }
  }

  nominalSimpan: number | null = null;
  formattedNominal: string = '';
  nominalCepat = [10000, 20000, 50000];
  selectedMetodePembayaran: string = '';

  formatAmount() {
    // Format ke Rupiah
    this.formattedNominal = this.currencyPipe.transform(
      this.nominalSimpan, 
      'Rp', 
      'symbol', 
      '1.0-0'
    ) || 'Rp0';
  }
  
  pilihSimpan(nominal: number) {
    this.nominalSimpan = nominal;
    this.formatAmount();
  }

  lanjutKonfirmasi() {
    // if (!this.selectedMetodePembayaran) {
    // alert('Silakan pilih metode pembayaran terlebih dahulu');
    // return;
    // }

    // Validasi jika nominal belum diisi
    if (!this.nominalSimpan || this.nominalSimpan < 10000) {
      alert('Masukkan nominal minimal Rp10.000');
      return;
    }
    
    const metode = this.metodePembayaranList.find(m => m.value === this.selectedMetodePembayaran);
    
    // Navigasi ke halaman konfirmasi dengan membawa data
    this.router.navigate(['/konfirmasi-simpanan'], {
      state: {
        nominal: this.nominalSimpan,
        jenisPembayaran: this.segment,
        formattedNominal: this.formattedNominal,
        metodePembayaranLabel: metode?.label || '',
        metodePembayaranRekening: metode?.rekening || ''
      }
      
    });
  }

  loadBerandaData() {
    const user = JSON.parse(localStorage.getItem('user') || '{}');
    const anggotaId = user?.id;

    this.http.get<any>(`http://localhost:8000/api/beranda-data/${anggotaId}`).subscribe(res => {
      if (res.status === 'success') {
        this.saldoSukarela = res.data.saldo_sukarela;
        this.saldoWajib = res.data.saldo_wajib;
      }
    });
  }

}
