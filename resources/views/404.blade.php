<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SIPD | Data Tidak Ditemukan</title>
    <link href="{!! asset(mix('css/app.css')) !!}" rel="stylesheet">
</head>
<body>
  <div class="wrapper">
      <section class="content">
          <div class="container-fluid">
              <div class="error-page">
                <div class="error-content" style="margin-left:0px !important; margin-top:50%;">
                  <h3 style="text-align: center;"><i class="fa fa-exclamation-triangle text-warning"></i> Data Tidak Ditemukan!</h3>
                  <p style="text-align: center;">Silahkan lakukan pencarian data kembali dengan menyertakan data yang sesuai.</p>
                </div>
              </div>
          </div>
      </section>
  </div>
</body>
</html>