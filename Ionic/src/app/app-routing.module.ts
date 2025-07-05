import { NgModule } from '@angular/core';
import { PreloadAllModules, RouterModule, Routes } from '@angular/router';

const routes: Routes = [
  {
    path: '',
    redirectTo: 'login',
    pathMatch: 'full'
  },
  {
    path: 'login',
    loadChildren: () => import('./login/login.module').then(m => m.LoginPageModule)
  },
  {
    path: 'anggota',
    loadChildren: () => import('./anggota/tabs-anggota/tabs-anggota.module').then( m => m.TabsAnggotaPageModule)
  },
  {
    path: 'riwayat-transaksi',
    loadChildren: () => import('./anggota/riwayat-transaksi/riwayat-transaksi.module').then( m => m.RiwayatTransaksiPageModule)
  },
  {
    path: 'notifikasi',
    loadChildren: () => import('./anggota/notifikasi/notifikasi.module').then( m => m.NotifikasiPageModule)
  },
  {
    path: 'bayar-tagihan',
    loadChildren: () => import('./anggota/bayar-tagihan/bayar-tagihan.module').then( m => m.BayarTagihanPageModule)
  },
  {
    path: 'hasil-bayar',
    loadChildren: () => import('./anggota/hasil-bayar/hasil-bayar.module').then( m => m.HasilBayarPageModule)
  },
  {
    path: 'konfirmasi-simpanan',
    loadChildren: () => import('./anggota/konfirmasi-simpanan/konfirmasi-simpanan.module').then( m => m.KonfirmasiSimpananPageModule)
  },
  {
    path: 'hasil-transfer',
    loadChildren: () => import('./anggota/hasil-transfer/hasil-transfer.module').then( m => m.HasilTransferPageModule)
  },
  {
    path: 'hasil-pinjaman',
    loadChildren: () => import('./anggota/hasil-pinjaman/hasil-pinjaman.module').then( m => m.HasilPinjamanPageModule)
  },
  {
    path: 'kolektor',
    loadChildren: () => import('./kolektor/tabs-kolektor/tabs-kolektor.module').then( m => m.TabsKolektorPageModule)
  },
  {
    path: 'notifikasi-kolektor',
    loadChildren: () => import('./kolektor/notifikasi-kolektor/notifikasi-kolektor.module').then( m => m.NotifikasiKolektorPageModule)
  },
  {
    path: 'riwayat-transaksi-kolektor',
    loadChildren: () => import('./kolektor/riwayat-transaksi-kolektor/riwayat-transaksi-kolektor.module').then( m => m.RiwayatTransaksiKolektorPageModule)
  },
  {
    path: 'bayar-angsuran',
    loadChildren: () => import('./kolektor/bayar-angsuran/bayar-angsuran.module').then( m => m.BayarAngsuranPageModule)
  },
  {
    path: 'hasil-transfer-angsuran',
    loadChildren: () => import('./kolektor/hasil-transfer-angsuran/hasil-transfer-angsuran.module').then( m => m.HasilTransferAngsuranPageModule)
  },
  {
    path: 'konfirmasi-angsuran',
    loadChildren: () => import('./kolektor/konfirmasi-angsuran/konfirmasi-angsuran.module').then( m => m.KonfirmasiAngsuranPageModule)
  },
  {
    path: 'rincian-transaksi',
    loadChildren: () => import('./kolektor/rincian-transaksi/rincian-transaksi.module').then( m => m.RincianTransaksiPageModule)
  },
  {
    path: 'detail-modal',
    loadChildren: () => import('./kolektor/detail-modal/detail-modal.module').then( m => m.DetailModalPageModule)
  },
];

@NgModule({
  imports: [
    RouterModule.forRoot(routes, { preloadingStrategy: PreloadAllModules })
  ],
  exports: [RouterModule]
})
export class AppRoutingModule { }
