import { Component } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-tab-pinjaman',
  templateUrl: './tab-pinjaman.page.html',
  styleUrls: ['./tab-pinjaman.page.scss'],
  standalone: false
})
export class TabPinjamanPage {

  constructor(private router : Router) {
    this.updateTenorNominal();
  }

  minValue: number = 200000;
  maxValue: number = 5000000;
  stepValue: number = 50000; // Step Rp50.000
  rangeValue: number = this.minValue;
  selectedTujuanPinjaman: string = '';
  selectedBankTujuan: string = '';
  biayaBunga: number = 0;
  subtotal: number = 0;
  biayaPerhari: number = 0;
  tenorDipilih: number | null = null;

  // Format angka ke mata uang Rupiah
  formatCurrency(value: number): string {
    return new Intl.NumberFormat('id-ID', {
      style: 'currency',
      currency: 'IDR',
      minimumFractionDigits: 0
    }).format(value);
  }

  tenorOptions = [
    {
      label: '3 Bulan/90 Hari',
      days: 90,
      nominal: 0
    },
    {
      label: '6 Bulan/180 Hari',
      days: 180,
      nominal: 0
    }
  ];

  updateValue() {
    console.log(this.rangeValue);
    this.biayaBunga = this.rangeValue * 0.05;
    this.subtotal = this.rangeValue + this.biayaBunga;
    this.updateTenorNominal();
  }

  updateTenorNominal() {
    this.tenorOptions.forEach(option => {
      option.nominal = this.subtotal / option.days;
    })
  }

  pilihTenor(index : number) {
    this.tenorDipilih = index;
    this.biayaPerhari = this.tenorOptions[index].nominal;
  }

  getCicilanLabel(): string {
    if (this.tenorDipilih === null) return 'Pilih Tenor';
    
    const selectedTenor = this.tenorOptions[this.tenorDipilih];
    // Mengambil angka bulan dari label (contoh: "3 Bulan/90 Hari" -> "3 Bulan")
    return selectedTenor.label.split('/')[0];
  }

  // Fungsi untuk navigasi
  goToHasilPinjaman() {
    if (this.tenorDipilih === null) {
    // Tampilkan alert atau toast bahwa tenor harus dipilih
    return;
    }

    const transferData = {
      danaDiajukan: this.rangeValue,
      selectedBankTujuan: this.selectedBankTujuan,
      subtotal: this.subtotal,
      biayaPerhari: this.biayaPerhari,
      tenor: this.tenorOptions[this.tenorDipilih].label,
      tanggal: new Date().toLocaleString('id-ID', {
        weekday: 'long',
        day: 'numeric',
        month: 'long',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
      }),
    }

    this.router.navigate(['/hasil-pinjaman'], {
      state: transferData
    });
  }

}
