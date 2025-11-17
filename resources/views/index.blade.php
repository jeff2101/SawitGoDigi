<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>SawitGoDigi</title>
  <meta name="description" content="" />
  <meta name="keywords" content="" />

  <!-- Favicons -->
  <link href="assets/img/sawit.png" rel="icon" />
  <link href="assets/img/sawit.png" rel="apple-touch-icon" />

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect" />
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet" />

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
  <link href="assets/vendor/aos/aos.css" rel="stylesheet" />
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet" />
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet" />

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">




  <!-- =======================================================
  * Template Name: Bootslander
  * Template URL: https://bootstrapmade.com/bootslander-free-bootstrap-landing-page-template/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">
  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <img src="assets/img/sawit.png" alt="" />
        <h1 class="sitename">SawitGoDigi</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="#hero" class="active">Home</a></li>
          <li><a href="#about">Tentang Kami</a></li>
          <li><a href="#visi-misi">Visi & Misi</a></li>
          <li><a href="#features">Fitur</a></li>
          <li><a href="#gallery">Galeri</a></li>
          <li><a href="#testimonials">Testimoni</a></li>
          <li><a href="#faq">FAQ</a></li>
          <li><a href="#contact">Kontak</a></li>

          <!-- ✅ Tombol Login dengan ukuran lebih besar -->
          <li>
            <a href="{{ route('login') }}" class="btn text-white"
              style="background-color: #6dbe45; margin-left: 10px; padding: 10px 20px; font-size: 16px; border-radius: 8px;">
              Login
            </a>
          </li>


        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

    </div>
  </header>

  <main class="main">
    <!-- Modal Unduhan Aplikasi -->
    <div class="modal fade" id="popupUnduh" tabindex="-1" aria-labelledby="popupUnduhLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg border-0 rounded-4 p-4">
          <div class="modal-header bg-success text-white rounded-top-4">
            <h5 class="modal-title d-flex align-items-center gap-2" id="popupUnduhLabel">
              <i class="bi bi-android2 fs-3"></i> Unduh Aplikasi Android
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
          </div>
          <div class="modal-body text-center py-4 px-3">
            <img src="assets/img/sawit.png" alt="SawitGoDigi APK" class="img-fluid mb-3" style="max-width: 150px;" />

            <p class="fs-5 fw-semibold mb-2">📲 Gunakan aplikasi <strong>SawitGoDigi</strong> di Android</p>
            <p class="text-muted mb-4">Mencatat & memantau hasil panen secara efisien langsung dari ponsel Anda.</p>

            <a href="https://sawitgodigi.site/apk/sawitgodigi.apk"
              class="btn btn-success btn-lg rounded-pill px-4 py-2 shadow-sm mb-3" target="_blank">
              <i class="bi bi-cloud-arrow-down-fill me-2"></i> Unduh Sekarang
            </a>

            <!--<div class="alert alert-warning small mt-3" role="alert">-->
            <!--  ⚠ Jika muncul peringatan seperti "<strong>File mungkin berbahaya</strong>", klik <strong>"Tetap Download"</strong>.-->
            <!--  <br>Karena aplikasi belum diunggah ke Google Play Store.-->
            <!--</div>-->
          </div>
        </div>
      </div>
    </div>

    <!-- Hero Section -->
    <section id="hero" class="hero section dark-background">
      <img src="assets/img/hero-bg-2.jpg" alt="" class="hero-bg" />

      <div class="container">
        <div class="row gy-4 justify-content-between">

          <!-- Gambar Hero -->
          <div class="col-lg-4 order-lg-last hero-img" data-aos="zoom-out" data-aos-delay="100">
            <img src="assets/img/hero-img.png" class="img-fluid animated" alt="" />
          </div>

          <!-- Konten Teks -->
          <div class="col-lg-6 d-flex flex-column justify-content-center" data-aos="fade-in">
            <h1>
              Digitalisasi Pencatatan Hasil Panen <br />
              Bersama <strong>SawitGoDigi</strong>
            </h1>
            <p>
              SawitGoDigi adalah solusi aplikasi web dan mobile yang
              memudahkan petani dan agen dalam mencatat dan memantau hasil
              panen secara efisien dan terintegrasi.
            </p>

            <!-- Tombol -->
            <div class="d-flex">
              <a href="https://sawitgodigi.site/apk/sawitgodigi.apk"
                class="btn btn-success d-inline-flex align-items-center px-4 py-2 shadow-lg rounded-pill"
                style="font-size: 1.1rem; gap: 0.5rem;" target="_blank">
                <i class="bi bi-android2" style="font-size: 1.5rem;"></i>
                <span>Unduh Aplikasi Android</span>
              </a>

              <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8"
                class="glightbox btn-watch-video d-flex align-items-center" target="_blank">
                <i class="bi bi-play-circle"></i><span>Lihat Video</span>
              </a>
            </div>
          </div>

        </div>
      </div>

      <!-- Gelombang SVG -->
      <svg class="hero-waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
        viewBox="0 24 150 28" preserveAspectRatio="none">
        <defs>
          <path id="wave-path" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z"></path>
        </defs>
        <g class="wave1">
          <use xlink:href="#wave-path" x="50" y="3"></use>
        </g>
        <g class="wave2">
          <use xlink:href="#wave-path" x="50" y="0"></use>
        </g>
        <g class="wave3">
          <use xlink:href="#wave-path" x="50" y="9"></use>
        </g>
      </svg>
    </section>

    <!-- /Hero Section -->

    <!-- About Section -->
    <section id="about" class="about section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row align-items-xl-center gy-5">

          <!-- Konten Kiri -->
          <div class="col-xl-5 content">
            {{-- judul kecil, biarkan statis saja --}}
            <h3>Tentang Kami</h3>

            {{-- judul utama: ambil dari tabel about --}}
            <h2>
              {{ $about->judul ?? 'Digitalisasi Pencatatan Hasil Panen Kelapa Sawit' }}
            </h2>

            {{-- deskripsi dari tabel about, tetap justify + support line break --}}
            <p style="text-align: justify">
              {!! nl2br(e($about->deskripsi ?? '')) !!}
            </p>

            {{-- tombol tetap seperti semula --}}
            <a href="#" class="read-more">
              <span>selengkapnya</span><i class="bi bi-arrow-right"></i>
            </a>
          </div>

          <!-- Konten Kanan (Icon Box) -->
          <div class="col-xl-7">
            <div class="row gy-4 icon-boxes">

              <div class="col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="icon-box">
                  <i class="bi bi-person-lines-fill"></i>
                  <h3>Integrasi Petani & Agen</h3>
                  <p style="text-align: justify">
                    Mencatat dan menghubungkan aktivitas petani dan agen
                    secara langsung dalam satu sistem.
                  </p>
                </div>
              </div>

              <div class="col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="icon-box">
                  <i class="bi bi-clipboard-data"></i>
                  <h3>Pencatatan Panen Akurat</h3>
                  <p style="text-align: justify">
                    Fitur penimbangan dan pelaporan hasil panen secara rinci,
                    berdasarkan lahan dan mutu buah.
                  </p>
                </div>
              </div>

              <div class="col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="icon-box">
                  <i class="bi bi-cash-coin"></i>
                  <h3>Transaksi Transparan</h3>
                  <p style="text-align: justify">
                    Sistem transaksi digital dengan bukti pembayaran dan
                    pemesanan otomatis.
                  </p>
                </div>
              </div>

              <div class="col-md-6" data-aos="fade-up" data-aos-delay="500">
                <div class="icon-box">
                  <i class="bi bi-graph-up"></i>
                  <h3>Statistik & Laporan</h3>
                  <p style="text-align: justify">
                    Menyajikan statistik panen dan laporan kinerja per petani,
                    agen, dan wilayah.
                  </p>
                </div>
              </div>

            </div>
          </div>

        </div>
      </div>
    </section>
    <section id="visi-misi" class="visi-misi section light-background">
      <div class="container" data-aos="fade-up">
        <div class="section-title text-center mb-5">
          <h2 class="highlight-title">🎯 Visi & Misi</h2>
          <p class="lead-description">
            Membangun masa depan pertanian sawit yang <strong>cerdas dan terintegrasi</strong>.
          </p>
          <div class="section-divider mx-auto mt-3 mb-2"></div>
        </div>

        <div class="row gy-4">
          <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100 p-4">
              <h3 class="text-success mb-3">
                <i class="bi bi-eye me-2"></i>Visi
              </h3>
              <p class="mb-0 text-muted">
                {!! nl2br(e($visiMisi->visi ?? 'Menjadi platform digital terpercaya yang merevolusi sistem pencatatan, distribusi, dan transaksi hasil panen sawit di Indonesia dengan teknologi yang mudah, transparan, dan terintegrasi.')) !!}
              </p>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100 p-4">
              <h3 class="text-primary mb-3">
                <i class="bi bi-bullseye me-2"></i>Misi
              </h3>
              <ul class="list-unstyled text-muted">
                @if(!empty($visiMisi?->misi))
                  @foreach(preg_split("/\r\n|\n|\r/", $visiMisi->misi) as $misiItem)
                    @if(trim($misiItem) !== '')
                      <li class="mb-2">
                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                        {{ $misiItem }}
                      </li>
                    @endif
                  @endforeach
                @else
                  {{-- fallback kalau belum ada data di DB --}}
                  <li class="mb-2">
                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                    Memberikan kemudahan pencatatan panen bagi petani dan agen secara digital.
                  </li>
                  <li class="mb-2">
                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                    Menyediakan sistem transaksi online yang transparan dan aman.
                  </li>
                  <li class="mb-2">
                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                    Meningkatkan produktivitas dan efisiensi melalui integrasi data panen.
                  </li>
                  <li>
                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                    Memberdayakan petani kecil dengan teknologi yang inklusif dan mudah diakses.
                  </li>
                @endif
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>

    {{-- Inline CSS --}}
    <style>
      #visi-misi .highlight-title {
        font-size: 32px;
        font-weight: 700;
        color: #1a3e24;
      }

      #visi-misi .lead-description {
        font-size: 17px;
        color: #444;
        max-width: 650px;
        margin: 0 auto;
      }

      #visi-misi .section-divider {
        width: 80px;
        height: 4px;
        background-color: #6dbe45;
        border-radius: 3px;
      }

      #visi-misi .card h3 i {
        vertical-align: middle;
      }

      #visi-misi ul li {
        font-size: 15px;
        line-height: 1.6;
      }

      @media (max-width: 767px) {
        #visi-misi .highlight-title {
          font-size: 26px;
        }

        #visi-misi .card {
          padding: 20px;
        }
      }
    </style>
    </section>


    <!-- /About Section -->

    <!-- Features Section -->

    <section id="features" class="features section">
      <div class="container">
        <div class="row gy-4">

          <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="100">
            <div class="features-item">
              <i class="bi bi-pencil-square" style="color: #ffbb2c"></i>
              <h3><a href="#" class="stretched-link">Pencatatan Panen Mudah</a></h3>
            </div>
          </div>

          <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="200">
            <div class="features-item">
              <i class="bi bi-cloud-upload" style="color: #5578ff"></i>
              <h3><a href="#" class="stretched-link">Penyimpanan Online</a></h3>
            </div>
          </div>

          <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="300">
            <div class="features-item">
              <i class="bi bi-receipt-cutoff" style="color: #e80368"></i>
              <h3><a href="#" class="stretched-link">Nota Digital Otomatis</a></h3>
            </div>
          </div>

          <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="400">
            <div class="features-item">
              <i class="bi bi-people" style="color: #e361ff"></i>
              <h3><a href="#" class="stretched-link">Manajemen Petani & Agen</a></h3>
            </div>
          </div>

          <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="500">
            <div class="features-item">
              <i class="bi bi-bar-chart-line" style="color: #47aeff"></i>
              <h3><a href="#" class="stretched-link">Statistik & Grafik Panen</a></h3>
            </div>
          </div>

          <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="600">
            <div class="features-item">
              <i class="bi bi-cash-stack" style="color: #ffa76e"></i>
              <h3><a href="#" class="stretched-link">Penghitungan Upah Otomatis</a></h3>
            </div>
          </div>

          <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="700">
            <div class="features-item">
              <i class="bi bi-phone" style="color: #11dbcf"></i>
              <h3><a href="#" class="stretched-link">Akses dari HP & Web</a></h3>
            </div>
          </div>

          <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="800">
            <div class="features-item">
              <i class="bi bi-lock" style="color: #4233ff"></i>
              <h3><a href="#" class="stretched-link">Keamanan Data Terjamin</a></h3>
            </div>
          </div>
          <div class="text-center mt-4">
            <a href="#" class="btn btn-outline-success">
              Lihat Semua Fitur
            </a>
          </div>
        </div>
      </div>
    </section>

    <!-- /Features Section -->

    <!-- Stats Section -->
    <section id="stats" class="stats section light-background">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4 justify-content-center">

          <div class="col-lg-2 col-md-4 col-6 d-flex flex-column align-items-center">
            <i class="bi bi-person-check"></i>
            <div class="stats-item">
              <span>134</span>
              <p>Petani Terdaftar</p>
            </div>
          </div>

          <div class="col-lg-2 col-md-4 col-6 d-flex flex-column align-items-center">
            <i class="bi bi-shop"></i>
            <div class="stats-item">
              <span>21</span>
              <p>Agen Sawit Aktif</p>
            </div>
          </div>

          <div class="col-lg-2 col-md-4 col-6 d-flex flex-column align-items-center">
            <i class="bi bi-truck-front"></i>
            <div class="stats-item">
              <span>47</span>
              <p>Sopir Terdaftar</p>
            </div>
          </div>

          <div class="col-lg-2 col-md-4 col-6 d-flex flex-column align-items-center">
            <i class="bi bi-receipt"></i>
            <div class="stats-item">
              <span>987</span>
              <p>Transaksi Panen</p>
            </div>
          </div>

          <div class="col-lg-2 col-md-4 col-6 d-flex flex-column align-items-center">
            <i class="bi bi-graph-up"></i>
            <div class="stats-item">
              <span>278</span>
              <p>Total Berat TBS (Ton)</p>
            </div>
          </div>

        </div>
      </div>
    </section>

    <!-- /Stats Section -->



    <!-- Gallery Section -->
    <section id="gallery" class="gallery section">
      <div class="container section-title" data-aos="fade-up">
        <h2>Galeri Kegiatan</h2>
        <div>
          <span>Lihat</span>
          <span class="description-title">Aktivitas Kami</span>
        </div>
      </div>

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row g-0">

          @if(isset($galleries) && $galleries->count())
            {{-- FOTO DARI DATABASE --}}
            @foreach ($galleries as $item)
              <div class="col-lg-3 col-md-4">
                <div class="gallery-item">
                  <a href="{{ asset('storage/' . $item->image_path) }}" class="glightbox" data-gallery="images-gallery"
                    title="{{ $item->judul ?? 'Foto galeri' }}">
                    <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->judul ?? 'Foto galeri' }}"
                      class="img-fluid">
                  </a>
                </div>
              </div>
            @endforeach
          @else
            {{-- FALLBACK: PAKAI FOTO STATIS LAMA JIKA BELUM ADA DATA DI DB --}}
            @php
              $galleryImages = [
                ['file' => 'sawit.png', 'caption' => 'Ilustrasi buah sawit segar'],
                ['file' => 'gallery-2.jpg', 'caption' => 'Aktivitas tim di lapangan'],
                ['file' => 'gallery-3.jpg', 'caption' => 'Pencatatan panen harian'],
                ['file' => 'gallery-4.jpg', 'caption' => 'Pengangkutan hasil panen'],
                ['file' => 'gallery-5.jpg', 'caption' => 'Pemantauan lahan sawit'],
                ['file' => 'gallery-6.jpg', 'caption' => 'Sosialisasi aplikasi ke petani'],
                ['file' => 'gallery-7.jpg', 'caption' => 'Penggunaan aplikasi di lapangan'],
                ['file' => 'gallery-8.jpg', 'caption' => 'Distribusi hasil panen'],
              ];
            @endphp

            @foreach ($galleryImages as $img)
              <div class="col-lg-3 col-md-4">
                <div class="gallery-item">
                  <a href="{{ asset('assets/img/gallery/' . $img['file']) }}" class="glightbox"
                    data-gallery="images-gallery" title="{{ $img['caption'] }}">
                    <img src="{{ asset('assets/img/gallery/' . $img['file']) }}" alt="{{ $img['caption'] }}"
                      class="img-fluid">
                  </a>
                </div>
              </div>
            @endforeach
          @endif

        </div>

        {{-- Tombol Lihat Galeri Lengkap --}}
        <div class="text-center mt-4">
          <a href="#" class="btn btn-outline-success px-4 py-2 rounded-pill">
            Lihat Galeri Lengkap
          </a>
        </div>
      </div>

      {{-- CSS Inline --}}
      <style>
        .gallery-item {
          position: relative;
          overflow: hidden;
        }

        .gallery-item::before {
          content: "";
          display: block;
          padding-top: 75%;
          /* 4:3 ratio */
        }

        .gallery-item img {
          position: absolute;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          object-fit: cover;
          transition: transform 0.3s ease, filter 0.3s ease;
        }

        .gallery-item:hover img {
          transform: scale(1.05);
          filter: brightness(85%);
        }

        .btn-outline-success {
          font-size: 16px;
          transition: all 0.3s ease;
        }

        .btn-outline-success:hover {
          background-color: #6dbe45;
          color: white;
          border-color: #6dbe45;
        }
      </style>
    </section>
    <!-- /Gallery Section -->

    <div class="swiper-wrapper">
      @foreach($testimonials as $t)
        <div class="swiper-slide">
          <div class="testimonial-item">
            <img src="{{ asset('assets/img/' . ($t->foto_path ?? 'testimonials/default.jpg')) }}" class="testimonial-img"
              alt="{{ $t->nama }}" />

            <h3>{{ $t->nama }}</h3>
            <h4>{{ $t->peran }}</h4>
            <p>
              <i class="bi bi-quote quote-icon-left"></i>
              <span class="fst-italic">
                {{ $t->konten }}
              </span>
              <br /><br />
              @if(!empty($t->no_hp))
                No HP: {{ $t->no_hp }}<br />
              @endif

              @if(!empty($t->alamat))
                Alamat: {{ $t->alamat }}<br />
              @endif

              @if(!empty($t->harga_jual))
                <strong>Harga Jual Sawit: {{ $t->harga_jual }}</strong>
              @endif

              <i class="bi bi-quote quote-icon-right"></i>
            </p>
          </div>
        </div>
      @endforeach
    </div>

    <!-- Faq Section -->
    <section id="faq" class="faq section light-background">
      <div class="container-fluid">
        <div class="row gy-4">
          <div class="col-lg-7 d-flex flex-column justify-content-center order-2 order-lg-1">
            <div class="content px-xl-5" data-aos="fade-up" data-aos-delay="100">
              <h3><span>Pertanyaan yang Sering </span><strong>Diajukan</strong></h3>
              <p>
                Kami telah merangkum beberapa pertanyaan umum beserta jawabannya untuk membantu Anda memahami layanan
                dan fitur kami dengan lebih baik.
              </p>
            </div>

            <div class="faq-container px-xl-5" data-aos="fade-up" data-aos-delay="200">

              @if(isset($faqs) && $faqs->count())
                {{-- versi DINAMIS: ambil dari tabel faqs --}}
                @foreach ($faqs as $index => $faq)
                  <div class="faq-item {{ $loop->first ? 'faq-active' : '' }}">
                    <i class="faq-icon bi bi-question-circle"></i>
                    <h3>{{ $faq->pertanyaan }}</h3>
                    <div class="faq-content">
                      <p>{!! nl2br(e($faq->jawaban)) !!}</p>
                    </div>
                    <i class="faq-toggle bi bi-chevron-right"></i>
                  </div>
                @endforeach
              @else
                {{-- fallback SEMENTARA: pakai data statis lama --}}
                @php
                  $faqList = [
                    [
                      'question' => 'Bagaimana cara mendaftar sebagai petani atau agen?',
                      'answer' => 'Anda dapat mendaftar melalui form pendaftaran di halaman login atau hubungi admin koperasi Anda.',
                      'active' => true,
                    ],
                    [
                      'question' => 'Apakah saya bisa melihat riwayat panen sebelumnya?',
                      'answer' => 'Ya, aplikasi menyimpan seluruh riwayat panen dan transaksi Anda yang dapat dilihat kapan saja.',
                    ],
                    [
                      'question' => 'Bagaimana cara melihat jumlah upah atau potongan saya?',
                      'answer' => 'Anda bisa melihat rincian upah panen, angkut, dan potongan dari halaman detail transaksi.',
                    ],
                    [
                      'question' => 'Apakah tersedia versi aplikasi mobile?',
                      'answer' => 'Tentu, Anda bisa mengunduh aplikasi versi Android melalui tautan yang tersedia di halaman utama.',
                    ],
                  ];
                @endphp

                @foreach ($faqList as $faq)
                  <div class="faq-item {{ $faq['active'] ?? false ? 'faq-active' : '' }}">
                    <i class="faq-icon bi bi-question-circle"></i>
                    <h3>{{ $faq['question'] }}</h3>
                    <div class="faq-content">
                      <p>{{ $faq['answer'] }}</p>
                    </div>
                    <i class="faq-toggle bi bi-chevron-right"></i>
                  </div>
                @endforeach
              @endif

            </div>
          </div>

          <div class="col-lg-5 order-1 order-lg-2">
            <img src="{{ asset('assets/img/faq.jpg') }}" class="img-fluid" alt="FAQ Image" data-aos="zoom-in"
              data-aos-delay="100" />
          </div>
        </div>
      </div>
    </section>
    <!-- /Faq Section -->


    <!-- Contact Section -->
    <section id="contact" class="contact section">
      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Kontak Kami</h2>
        <div>
          <span>Hubungi</span>
          <span class="description-title">Kami</span>
        </div>
      </div>
      <!-- End Section Title -->

      <div class="container" data-aos="fade" data-aos-delay="100">
        <div class="row gy-4">
          <div class="col-lg-4">
            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="200">
              <i class="bi bi-geo-alt flex-shrink-0"></i>
              <div>
                <h3>Lokasi</h3>
                <p>
                  POLITEKNIK NEGERI BENGKALIS, Sungai Alam, Kec. Bengkalis,
                  Kabupaten Bengkalis, Riau 28714
                </p>
              </div>
            </div>
            <!-- End Info Item -->

            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
              <i class="bi bi-telephone flex-shrink-0"></i>
              <div>
                <h3>Telepon</h3>
                <p>+6281275037017</p>
              </div>
            </div>
            <!-- End Info Item -->

            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
              <i class="bi bi-envelope flex-shrink-0"></i>
              <div>
                <h3>Email</h3>
                <p>risetsawitgroup@gmail.com</p>
              </div>
            </div>
            <!-- End Info Item -->
          </div>

          <div class="col-lg-8" data-aos="fade-up" data-aos-delay="200">
            <iframe
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.5251737722683!2d102.14831241003685!3d1.4588030985213305!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d15f5cf1bf080b%3A0x65c55404575d4d59!2sPOLITEKNIK%20NEGERI%20BENGKALIS!5e0!3m2!1sid!2sid!4v1746610388386!5m2!1sid!2sid"
              width="100%" height="400" style="border: 0" allowfullscreen="" loading="lazy"
              referrerpolicy="no-referrer-when-downgrade">
            </iframe>
          </div>

          <!-- End Contact Form -->
        </div>
      </div>
    </section>
    <!-- /Contact Section -->
  </main>

  <footer id="footer" class="footer dark-background">
    <div class="container footer-top">
      <div class="row gy-4">

        {{-- Tentang Aplikasi --}}
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="#" class="logo d-flex align-items-center">
            <img src="assets/img/sawit.png" alt="Logo SawitGoDigi" style="height: 40px; margin-right: 10px" />
            <span class="sitename">SawitGoDigi</span>
          </a>
          <div class="footer-contact pt-3">
            <p>Politeknik Negeri Bengkalis</p>
            <p>Jl. Bathin Alam, Sungai Alam, Riau 28711</p>
            <p class="mt-3"><strong>Telepon:</strong> <span>0812-7503-7017</span></p>
            <p><strong>Email:</strong> <span>risetsawitgroup@gmail.com</span></p>
          </div>
          <div class="social-links d-flex mt-4">
            <a href="#"><i class="bi bi-facebook"></i></a>
            <a href="#"><i class="bi bi-instagram"></i></a>
            <a href="#"><i class="bi bi-youtube"></i></a>
          </div>
        </div>

        {{-- Tautan Cepat --}}
        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Tautan Cepat</h4>
          <ul>
            <li><a href="#hero">Beranda</a></li>
            <li><a href="#about">Tentang Kami</a></li>
            <li><a href="#features">Fitur</a></li>
            <li><a href="#gallery">Galeri</a></li>
            <li><a href="#faq">FAQ</a></li>
          </ul>
        </div>

        {{-- Layanan --}}
        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Layanan</h4>
          <ul>
            <li><a href="#">Pencatatan Panen</a></li>
            <li><a href="#">Manajemen Petani</a></li>
            <li><a href="#">Transaksi Digital</a></li>
            <li><a href="#">Laporan Kinerja</a></li>
          </ul>
        </div>

        {{-- CTA Ajak Daftar --}}
        <div class="col-lg-4 col-md-12">
          <h4>Gabung Bersama SawitGoDigi</h4>
          <p>
            Mudahkan pencatatan dan transaksi panen Anda dengan platform digital kami.
            Daftar dan rasakan kemudahannya!
          </p>
          <a href="#" class="btn btn-success mt-2">
            Daftar Sekarang
          </a>
        </div>

      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p>&copy; 2025 <strong class="px-1 sitename">SawitGoDigi</strong>. Hak Cipta Dilindungi</p>
      <div class="credits">Dikembangkan oleh <strong>SawitGoDigi Team</strong></div>
    </div>
  </footer>


  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script>
    window.addEventListener('DOMContentLoaded', (event) => {
      const popup = new bootstrap.Modal(document.getElementById('popupUnduh'));
      setTimeout(() => {
        popup.show();
      }, 2000); // Muncul otomatis setelah 2 detik
    });
  </script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>
</body>

</html>