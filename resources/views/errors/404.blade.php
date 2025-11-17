<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>404 - Halaman Tidak Ditemukan</title>
  <link href="https://fonts.googleapis.com/css2?family=Arvo&display=swap" rel="stylesheet">
  <style>
    /*======================
        404 page
    =======================*/
    .page_404 {
      padding: 40px 0;
      background: #fff;
      font-family: 'Arvo', serif;
    }

    .page_404 img {
      width: 100%;
    }

    .four_zero_four_bg {
      background-image: url(https://cdn.dribbble.com/users/285475/screenshots/2083086/dribbble_1.gif);
      height: 400px;
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
    }

    .four_zero_four_bg h1 {
      font-size: 80px;
    }

    .four_zero_four_bg h3 {
      font-size: 80px;
    }

    .link_404 {
      color: #fff !important;
      padding: 10px 20px;
      background: #1b4d3e;
      margin: 20px 0;
      display: inline-block;
      text-decoration: none;
      border-radius: 5px;
    }

    .contant_box_404 {
      margin-top: -50px;
    }

    /* Optional responsive container mock */
    .container {
      max-width: 960px;
      margin: 0 auto;
      padding: 0 15px;
    }

    .row {
      display: flex;
      justify-content: center;
    }

    .col-sm-12, .col-sm-10 {
      width: 100%;
    }

    .text-center {
      text-align: center;
    }

    .col-sm-offset-1 {
      margin: 0 auto;
    }
  </style>
</head>
<body>
  <section class="page_404">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="col-sm-10 col-sm-offset-1 text-center">
            <div class="four_zero_four_bg">
              <h1 class="text-center">404 - Error</h1>
            </div>

            <div class="contant_box_404">
              <h3 class="h2">Ups! Maaf, halaman yang kamu cari tidak ditemukan...</h3>
              <p>Sepertinya kamu tersesat di ladang sawit. Ayo kembali ke rumah!</p>
              <a href="{{ url('/') }}" class="link_404">Kembali ke Beranda</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>
</html>