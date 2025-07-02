import { Component } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-bayar-tagihan',
  templateUrl: './bayar-tagihan.page.html',
  styleUrls: ['./bayar-tagihan.page.scss'],
  standalone: false,
})
export class BayarTagihanPage {
  totalPayment: string = 'Rp0';
  selectedMethod: string = '';
  unpaidBills: string = 'Rp0';
  bills = [
    {
      amount: 'Rp50.000',
      checked: false,
      details: {
        tenor: '3 Bulan',
        tagihan: 'Rp50.000',
        jatuhTempo: '18 Mei 2025'
      }
    },
    {
      amount: 'Rp50.000',
      checked: false,
      details: {
        tenor: '3 Bulan',
        tagihan: 'Rp50.000',
        jatuhTempo: '18 Mei 2025'
      }
    },
    {
      amount: 'Rp50.000',
      checked: false,
      details: {
        tenor: '3 Bulan',
        tagihan: 'Rp50.000',
        jatuhTempo: '18 Mei 2025'
      }
    },
    {
      amount: 'Rp50.000',
      checked: false,
      details: {
        tenor: '3 Bulan',
        tagihan: 'Rp50.000',
        jatuhTempo: '18 Mei 2025'
      }
    }
  ];

  constructor(private router: Router) {}

  calculateTotal() {
    let total = 0;
    let unpaidTotal = 0;
    
    this.bills.forEach(bill => {
      const amount = parseInt(bill.amount.replace(/\D/g, ''));
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

  onPaymentMethodChange(event: any) {
    this.selectedMethod = event.detail.value;
  }

  processPayment() {
    const currentDate = new Date();
    const paymentData = {
      totalPaid: this.totalPayment,
      paymentMethod: this.selectedMethod,
      paymentDate: currentDate.toLocaleDateString('id-ID'),
      paymentTime: currentDate.toLocaleTimeString('id-ID'),
      unpaidBills: this.unpaidBills
    };

    this.router.navigate(['/hasil-bayar'], {
      state: { data: paymentData }
    });
  }
}
