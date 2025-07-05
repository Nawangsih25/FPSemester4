import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { HttpClient } from '@angular/common/http';

@Component({
  selector: 'app-bayar-tagihan',
  templateUrl: './bayar-tagihan.page.html',
  styleUrls: ['./bayar-tagihan.page.scss'],
  standalone: false,
})
export class BayarTagihanPage implements OnInit {
  bills: any[] = [];
  totalPayment: string = 'Rp0';
  unpaidBills: string = 'Rp0';
  selectedMetodePembayaran: string = '';
  metodePembayaranList = [
    { value: 'bni', label: 'Bank BNI', rekening: '1234567890' },
    { value: 'bjb', label: 'Bank BJB', rekening: '9876543210' },
    { value: 'mandiri', label: 'Bank Mandiri', rekening: '1122334455' },
    { value: 'dana', label: 'Dana', rekening: '081234567890' },
    { value: 'gopay', label: 'Gopay', rekening: '081212121212' },
    { value: 'ovo', label: 'Ovo', rekening: '082233445566' }
  ];

  constructor(
    private router: Router,
    private http: HttpClient
  ) {}

  ngOnInit() {
    this.loadTagihanBelumBayar();
  }

  loadTagihanBelumBayar() {
    const user = JSON.parse(localStorage.getItem('user') || '{}');
    const anggotaId = user?.id;

    if (!anggotaId) return;

    this.http.get<any>(`http://localhost:8000/api/tagihan-belum-bayar/${anggotaId}`).subscribe(res => {
      if (res.status === 'success') {
        this.bills = res.data;
        this.calculateTotal();
      }
    });
  }

  calculateTotal() {
    let total = 0;
    let unpaidTotal = 0;

    this.bills.forEach(bill => {
      const amount = parseInt(bill.amount.replace(/\D/g, ''), 10);
      if (bill.checked) {
        total += amount;
      } else {
        unpaidTotal += amount;
      }
    });

    this.totalPayment = `Rp${total.toLocaleString('id-ID')}`;
    this.unpaidBills = `Rp${unpaidTotal.toLocaleString('id-ID')}`;
  }

  onCheckboxChange(event: any, index: number) {
    this.bills[index].checked = event.detail.checked;
    this.calculateTotal();
  }

  processPayment() {
    const currentDate = new Date();
    
    const metode = this.metodePembayaranList.find(m => m.value === this.selectedMetodePembayaran);

    const paymentData = {
      totalPaid: this.totalPayment,
      metodePembayaranLabel: metode?.label || '',
      metodePembayaranRekening: metode?.rekening || '',
      paymentDate: currentDate.toLocaleDateString('id-ID'),
      paymentTime: currentDate.toLocaleTimeString('id-ID'),
      unpaidBills: this.unpaidBills,
      bills: this.bills.filter(b => b.checked) // opsional: kirim data tagihan terpilih
    };

    this.router.navigate(['/konfirmasi-simpanan'], {
      state: { data: paymentData,
        metodePembayaranLabel: metode?.label || '—',
        metodePembayaranRekening: metode?.rekening || '—'
      }
    });
  }
}
