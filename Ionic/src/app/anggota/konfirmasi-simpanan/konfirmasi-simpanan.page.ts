import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';// Import jika digunakan
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Platform } from '@ionic/angular';

@Component({
  selector: 'app-konfirmasi-simpanan',
  templateUrl: './konfirmasi-simpanan.page.html',
  styleUrls: ['./konfirmasi-simpanan.page.scss'],
  standalone: false,
})
export class KonfirmasiSimpananPage implements OnInit {
  selectedFile: File | null = null;
  previewUrl: string | ArrayBuffer | null = null;
  nominal: number = 0;
  jenisPembayaran: string = '';
  formattedNominal: string = 'Rp0';
  metodePembayaranLabel: string = '';
  metodePembayaranRekening: string = '';


  // Untuk tagihan
  totalPaid: string = '';
  paymentMethod: string = '';
  paymentDate: string = '';
  paymentTime: string = '';
  unpaidBills: string = '';
  bills: any[] = [];

  // Umum
  paymentCode: string = '';
  status: string = 'Berhasil';

  constructor(
    private router: Router,
    private http: HttpClient,
    private platform: Platform,
  ) {
    const navigation = this.router.getCurrentNavigation();
    const state: any = navigation?.extras.state;

    if (state) {
      if (state.nominal && state.jenisPembayaran) {
        // Data dari tab-simpanan
        this.nominal = state.nominal;
        this.jenisPembayaran = state.jenisPembayaran;
        this.formattedNominal = state.formattedNominal || 'Rp0';
        this.metodePembayaranLabel = state.metodePembayaranLabel || '';
        this.metodePembayaranRekening = state.metodePembayaranRekening || '';

      } else if (state.data && state.data.totalPaid) {
        // Data dari bayar-tagihan
        const data = state.data;
        this.totalPaid = data.totalPaid;
        this.metodePembayaranLabel = state.metodePembayaranLabel || '';
        this.metodePembayaranRekening = state.metodePembayaranRekening || '';
        this.paymentDate = data.paymentDate;
        this.paymentTime = data.paymentTime;
        this.unpaidBills = data.unpaidBills;
        this.bills = data.bills;
      }
    }
  }

  ngOnInit() {
    this.generatePaymentCode();
  }

  generatePaymentCode() {
    const randomDigits = Math.floor(100000000000 + Math.random() * 900000000000);
    this.paymentCode = `${randomDigits.toString().slice(0, 12)}`;
  }

  // confirmPayment() {
  //   if (this.nominal && this.jenisPembayaran) {
  //     // Data dari simpanan
  //     const transferData = {
  //       nominal: this.nominal,
  //       jenisSimpanan: this.jenisPembayaran,
  //       formattedNominal: this.formattedNominal,
  //       paymentCode: this.paymentCode,
  //       metodePembayaranLabel: this.metodePembayaranLabel,
  //       tanggal: new Date().toLocaleString('id-ID', {
  //         weekday: 'long',
  //         day: 'numeric',
  //         month: 'long',
  //         year: 'numeric',
  //         hour: '2-digit',
  //         minute: '2-digit'
  //       }),
  //       status: 'Berhasil',
  //       source: 'simpanan'
  //     };

  //     this.router.navigate(['/hasil-transfer'], {
  //       state: transferData
  //     });

  //   } else {
  //     // Data dari tagihan
  //     const transferData = {
  //       totalPaid: this.totalPaid,
  //       paymentMethod: this.paymentMethod,
  //       paymentDate: this.paymentDate,
  //       paymentTime: this.paymentTime,
  //       unpaidBills: this.unpaidBills,
  //       paymentCode: this.paymentCode,
  //       bills: this.bills,
  //       status: 'Berhasil',
  //       source: 'tagihan'
  //     };

  //     this.router.navigate(['/hasil-transfer'], {
  //       state: transferData
  //     });
  //   }
  // }

  // LOGIKA BARU
  confirmPayment() {
    if (this.nominal && this.jenisPembayaran) {
      this.uploadPembayaranSimpanan(); // GANTI dari navigasi langsung
    } else {
      this.uploadPembayaranTagihan();
    }
  }
  

  goBack() {
    this.router.navigate(['/tabs/tab2']);
  }

  onFileSelected(event: any) {
    const file = event.target.files[0];
    if (file && (file.type === 'image/png' || file.type === 'image/jpeg' || file.type === 'image/jpg')) {
      this.selectedFile = file;

      const reader = new FileReader();
      reader.onload = () => {
        this.previewUrl = reader.result;
      };
      reader.readAsDataURL(file);
    } else {
      alert('File harus berupa gambar JPG atau PNG');
      event.target.value = ''; // Reset input jika bukan gambar valid
    }
  }

  //LOGIKA BARU
  uploadPembayaranSimpanan() {
    if (!this.selectedFile) {
      alert('Silakan upload bukti pembayaran.');
      return;
    }

    const user = JSON.parse(localStorage.getItem('user') || '{}');
    const token = localStorage.getItem('auth_token'); // ✅ sesuai key di localStorage

    const formData = new FormData();

    formData.append('anggota_id', user.id); // pastikan backend menerima `anggota_id`
    formData.append('jenis', this.jenisPembayaran); // wajib / sukarela
    formData.append('jumlah', this.nominal.toString());
    formData.append('metode', this.metodePembayaranLabel);
    formData.append('tanggal', new Date().toISOString().split('T')[0]); // yyyy-mm-dd
    formData.append('bukti_pembayaran', this.selectedFile);
    
    const headers = {
    Authorization: `Bearer ${token}` // ✅ pakai header token di sini
  };

    this.http.post('http://localhost:8000/api/anggota/pembayaran-simpanan', formData, { headers }).subscribe({
      next: (res: any) => {
        // setelah berhasil dikirim ke Laravel, redirect ke hasil-transfer
        const transferData = {
          nominal: this.nominal,
          jenisSimpanan: this.jenisPembayaran,
          formattedNominal: this.formattedNominal,
          paymentCode: res?.data?.id || this.paymentCode,
          metodePembayaranLabel: this.metodePembayaranLabel,
          tanggal: new Date().toLocaleString('id-ID', {
            weekday: 'long',
            day: 'numeric',
            month: 'long',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
          }),
          status: 'Pending',
          source: 'simpanan'
        };

        this.router.navigate(['/hasil-transfer'], { state: transferData });

        // Siapkan data riwayat
        const riwayatBaru = {
          nama: user.nama,
          nominal: this.nominal || this.totalPaid,
          jenis: this.jenisPembayaran || 'tagihan',
          tanggal: new Date().toISOString(),
          metode: this.metodePembayaranLabel,
          status: 'Pending',
          bukti: this.previewUrl || null
        };

        // Ambil riwayat lama
        const existing = JSON.parse(localStorage.getItem('riwayat_transaksi_anggota') || '[]');
        existing.unshift(riwayatBaru);
        localStorage.setItem('riwayat_transaksi_anggota', JSON.stringify(existing));
      },
      error: (err) => {
        console.error('Gagal mengirim data simpanan:', err);
        alert('Gagal mengirim data. Coba lagi.');
      }
    });
  }

  uploadPembayaranTagihan() {
    if (!this.selectedFile) {
      alert('Silakan upload bukti pembayaran tagihan.');
      return;
    }

    const user = JSON.parse(localStorage.getItem('user') || '{}');
    const token = localStorage.getItem('auth_token');

    const formData = new FormData();
    formData.append('anggota_id', user.id);
    formData.append('jenis', 'tagihan'); // 👈 penanda ini tagihan
    formData.append('jumlah', this.totalPaid.replace(/\D/g, '')); // Hilangkan Rp dan titik
    formData.append('metode', this.metodePembayaranLabel);
    formData.append('tanggal', new Date().toISOString().split('T')[0]);
    formData.append('bukti_pembayaran', this.selectedFile);

    const headers = {
      Authorization: `Bearer ${token}`
    };

    this.http.post('http://localhost:8000/api/anggota/pembayaran-simpanan', formData, { headers }).subscribe({
      next: (res: any) => {
        const transferData = {
          totalPaid: this.totalPaid,
          paymentMethod: this.metodePembayaranLabel,
          paymentDate: this.paymentDate,
          paymentTime: this.paymentTime,
          unpaidBills: this.unpaidBills,
          paymentCode: res?.data?.id || this.paymentCode,
          bills: this.bills,
          status: 'Pending',
          source: 'tagihan'
        };

        this.router.navigate(['/hasil-transfer'], { state: transferData });

        // Siapkan data riwayat
        const riwayatBaru = {
          nama: user.nama,
          nominal: this.nominal || this.totalPaid,
          jenis: this.jenisPembayaran || 'tagihan',
          tanggal: new Date().toISOString(),
          metode: this.metodePembayaranLabel,
          status: 'Pending',
          bukti: this.previewUrl || null
        };

        // Ambil riwayat lama
        const existing = JSON.parse(localStorage.getItem('riwayat_transaksi_anggota') || '[]');
        existing.unshift(riwayatBaru);
        localStorage.setItem('riwayat_transaksi_anggota', JSON.stringify(existing));
      },
      error: (err) => {
        console.error('Gagal mengirim data tagihan:', err);
        alert('Gagal mengirim data tagihan. Coba lagi.');
      }
    });
  }



}